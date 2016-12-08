<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post();
        $my_id = get_the_ID();
        $hm = get_post_meta($my_id,'homepage_link_value',true);
        if($hm=="") $hm = get_the_permalink();
        ?>
        <div class="post" id="post-<?php the_ID(); ?>">
            <!-- 基本信息部分 -->
            <div class="container basic-intro">
                <!-- 左边是基本信息 -->
                <div id="left" class="eight columns" >
                    <div class="title">
                        <h2><a href="<?php echo $hm ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?>&nbsp;&nbsp;<?php echo get_post_meta($my_id,'en_name_value',true); ?></a></h2>
                    </div>
                    <div class="basic-info">
                        <?php
                        $output = array(
                            "position" => array(
                                "icon"=>"icon-user",
                                "content"=>"",
                                "class"=>"position"
                            ),
                            "institute" => array(
                                "icon"=>"icon-library",
                                "content"=>"",
                                "class"=>"institute"
                            ),
                            "contact_addr" => array(
                                "icon"=>"icon-office",
                                "content"=>"",
                                "class"=>"contact_addr"
                            ),
                            "email_addr" => array(
                                "icon"=>"icon-mail4",
                                "content"=>"",
                                "class"=>"email_addr"
                            ),
                            "phone" => array(
                                "icon"=>"icon-phone",
                                "content"=>"",
                                "class"=>"phone_num"
                            ),
                            "fax" => array(
                                "icon"=>"icon-printer",
                                "content"=>"",
                                "class"=>"fax_num"
                            )
                        );
                        foreach ($output as $name => $value)
                        {
                            if($name == 'position')
                            {
                                // 身份
                                $term_list = wp_get_post_terms($my_id, 'people_category');
                                $output[$name]['content'] = $term_list[0]->name.'&nbsp;'.map_slug($term_list[0]->slug);
                                if(get_post_meta($my_id,'is_graduate_value',true)!='true') $output['position']['content'].='.Candidate';
                            }
                            else {
                                $output[$name]['content'] = get_post_meta($my_id, $name.'_value', true);
                            }
                            if(!empty($output[$name]['content'])) {
                                echo '<div class="intro-row">';
                                echo '<div class="icon"><span class="'.$output[$name]['icon'].' intro-icon"></span></div>';
                                echo '<div class="cont '.$output[$name]['class'].'">';
                                echo $output[$name]['content'];
                                echo '</div></div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <!-- 右边是图像 -->
                <div id="right" class="eight columns" >
                    <div class="intro-img">
                        <img src="<?php $medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'medium');
                        echo $medium_image_url[0]; ?>" alt="No Image"/>
                    </div>
                </div>
            </div>
            <!-- 固定版块们 -->
            <?php
            $intros = array(
                "self-intro" => array (
                    "title" => "introduction",
                    "get_from_meta" => ""
                ),
                "position" => array(
                    "title" => "positions",
                    "get_from_meta" => "position"
                ),
                "haa" => array(
                    "title" => "honors &amp; awards",
                    "get_from_meta" => "haa"
                ),
                "rinterest" => array(
                    "title" => "recent interests",
                    "get_from_meta" => "rec-interest"
                ),
                "rproject" => array(
                    "title" => "recent projects",
                    "get_from_meta" => "rec-project"
                ),
                "selected_paper" => array(
                    "title" => "selected papers",
                    "get_from_meta" => ""
                ),
                "recent_blog" => array(
                    "title" => "recent blogs",
                    "get_from_meta" => ""
                )
            );
            ?>
            <div class="container">
                <hr class="intro-hr">
                <div class="main-intro">
                <?php foreach ($intros as $name => $intro)
                {
                    $content = "";
                    switch ($name)
                    {
                        case "self-intro":
                            $content = get_the_content();
                            break;
                        case "selected_paper":
                            $query = new WP_Query( 'category_name=publication&posts_per_page=10' );
                            $is_emp = true;
                            while($query->have_posts()){
                                $query->the_post();
                                $data = get_post_meta(get_the_ID(), 'author_info_value',true);
                                if(preg_match("/(^".$my_id."$)|(^".$my_id.",\w+)|(\w+,".$my_id."$)|(\w+,".$my_id.",\w+)/",$data))
                                {
                                    if($is_emp) { $content = "<ol>";$is_emp=false;}
                                    $til = get_post_meta(get_the_ID(),'paper_reference_name',true);
                                    $url = get_the_permalink();
                                    $content.="<li><a href='".$url."'>".$til."</a></li>";
                                }
                            }
                            if(!empty($content)) $content.="</ol>";
                            wp_reset_postdata();
                            break;
                        case "recent_blog":
                            $query = new WP_Query( 'category_name=blog&posts_per_page=10' );
                            $is_emp = true;
                            while($query->have_posts()){
                                $query->the_post();
                                $data = get_post_meta(get_the_ID(), 'author_info_value',true);
                                if(preg_match("/(^".$my_id."$)|(^".$my_id.",\w+)|(\w+,".$my_id."$)|(\w+,".$my_id.",\w+)/",$data))
                                {
                                    if($is_emp) { $content = "<ul>";$is_emp=false;}
                                    $til = get_the_title();
                                    $url = get_the_permalink();
                                    $content.="<li><a href='".$url."'>".$til."</a></li>";
                                }
                            }
                            if(!empty($content)) $content.="</ul>";
                            wp_reset_postdata();
                            break;
                        default:
                            $content = get_post_meta($my_id, $intro['get_from_meta'].'_meta_eidtor_value',true);
                    }
                    if(!empty($content))
                    {
                        ?>
                        <div class="intro-module">
                            <div class="title">
                                <h2><?php echo $intro['title'];?></h2>
                            </div>
                            <div class="entry">
                                <?php echo $content; ?>
                            </div>
                        </div>
                        <?php
                    }
                }?>
                </div>
            </div>
        </div>
    <?php endwhile; endif; ?>
<?php get_footer(); ?>


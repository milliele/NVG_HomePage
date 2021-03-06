# NVG_HomePage

## Platform
Based on **WordPress 4.5.3** and Theme **[Yasmin](http://demo.fabthemes.com/yasmin/)**

## Plugins
* Admin Menu Editor
* WP-Mail-SMTP

## Documents

### 首页
* 团队介绍：目前没有做后台设置，需在Index.php里手动修改
* 幻灯片：显示【动态】分类下所有设置了特色图像的POST
* 新闻动态：显示【动态】分类下除【通知】之外的所有POST
* 通知：显示【通知】分类下的POST的标题

### 近期动态
分为【新闻-通知-活动-分类】等四个分类，在后台发布文章（POST）并将其分类目录勾选为相应分类即可。
#### 博客
由于博客需要明确作者，请在自定义面板【站内成员关联】内填入相应作者ID（作者ID可在【成员管理】内查看）
### 人员队伍
显示小组的所有成员
#### 前台显示
1. 【人员队伍】页面
    按分类归档出所有的成员，点击可以进入每个成员各自的主页
2. 【个人主页】页面
    显示个人的基本信息（成员分类，所属机构，通讯地址，邮箱，电话，传真），未设置的字段将不会显示
    显示其他详细个人介绍，其中“Introduction, Positions, Honors and Awards, Recent Projects, Recent Interests”都是自己在后台设置的，“Selected Paper”是通过将Publication里的文章设置作者关联来显示的，点每个文章的链接会进入该文章的详情

#### 成员分类
在后台【成员管理-成员分类】内管理：

* “名称”：为中文名称
* “别名”：为英文名称，别名里空格使用‘_’代替，**注意成员分类不分级，请勿设置父节点**
* “显示优先级”：在显示所有成员的页面中成员分类是按优先级从大到小排列的，请将想显示在前面的分类的优先级设置得高些

#### 成员管理
添加新成员的方式与写新文章（POST）相似，具体如下：

* 标题：成员中文名
* 正文：成员的详细的介绍
* 摘要：成员的简介，尽量简介，100~200字左右
* 成员介绍信息：每个编辑框内填写相应内容即可，建议不使用图片，使用有序或无序列表
* 成员基本信息：填写相应内容即可
    - **个人主页**：如果有自己的个人主页，填写URL即可，【正文】以及【成员介绍信息】都可不填；若无，可空着，使用网站自带的个人主页
* 成员分类：勾选相应分类，**有且只有一个分类**
* 特色图片：如果希望在个人主页上显示自己的照片，则设置为特色图像

### 发表成果
添加新发表成果的方式为：发布一篇文章，将其分类设置为“发表成果”
>请在【自定义字段】里选择【paper_reference_name】，设置这篇paper在成员主页的PAPER列表里显示的名字

### 研究方向
在【文章-Researches】里管理：
**注意研究方向不分级，请勿设置父节点**

* “名称”：为中文名称
* “别名”：为英文名称，别名里空格使用‘_’代替，**

### 其他
* Tag可以自由设置
* 所有的文章（POST），即【动态、发表成果】分类下的所有文章，都可以设置研究方向，方式为编辑文章的时候在“研究方向”面板里勾选相应方向

## 待完成
* 响应式设计
* 用户权限
* 部分后台设置更人性化
* 本地化
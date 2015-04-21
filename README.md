# 日新网手机客户端后台管理&数据接口

介绍
----

完成的功能有：CMS、推送管理、接口

使用了slim作为路由&请求封装，LaravelORM作为ORM，symfony的yaml解析配置

安装&使用
----

将```config.yml.sample```复制为```config.yml```，并且修改配置

由于使用了composer作为包管理工具，所以执行```composer update```

接口
----

 - /api/v1/index?[until=5]
 
 显示首页数据，按时间排序，包括滚动图和普通文章两部分。until用来指定直到某个ID之前的文章
 
 - /api/v1/articles?[until=5]
 
 显示所有文章，按时间排序
 
 - /api/v1/article/:id/view
 
 手机上用的显示页面，直接嵌入到APP
 
 - /api/v1/article/:id
 
 文章内容
 
 - /api/version
 
 APP的信息，返回的version_name是显示用版本号，version_code是真实版本号（递增不重复），md5是apk文件的md5

# note-pages

## 主题定义

>在views文件夹里面存在主题文件夹themes，比如说默认主题default，里面包含该主题的前端文件，除此之外还有一个配置文件config.json，该文件记录了不同页面需要加载的前段文件。
    
    default主题的目录结构
    
    default
    |-content.php
    |-body.php
    |-config.json
    
## 简单的访问流程
    
>        model   controller  view
>        
>                request
>                
>                |
>        <-------|
>        解析url |
>        ------->|
>        返回信息|
>                |
>        <-------|
>        查询主题|
>        ------->|
>        返回主题|
>                |
>                |---------->
>                |
>                |<----------
>                |加载主题文件
>                |
>    <-------------|
>    读取有道云笔记|
>    ------------->|
>    返回读取的内容|
>                |
>                |
>                
>        组合有道云笔记内容和主题文件
>        最终显示相对应的页面


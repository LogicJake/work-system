<template>
    <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-setting"></i> 自述</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="ms-doc">
              <h3>我要发布作业</h3>
            <article>
                <h1>发布作业</h1>
                <p>基于作业提交解决方案</p>
                <h2>前言</h2>
                <p> 南航首家线上交作业平台上线了。以后作业收取均通过班级作业系统提交，请大家先到https://erestu.win/work-system/dist/index.html#/login进行登陆，账号密码为教务处账号密码。登陆成功后填写邮箱信息，以后作业发布会有邮件提醒。大家抓紧登陆报道，否则后续无法提交作业。ps：以后不通过其他途径接受作业，方便大家，方便你我</p>
                <p>
                    联系QQ:849467474或QQ:835410808成为管理员
                </p>
                <p><a href="https://www.logicjake.xyz/">科西嘉blog</a></p>
                <p><a href="https://blog.erestu.win">小甲鱼blog</a></p>
                <p> 感谢科西嘉,小甲鱼技术提供技术支持</p>
                <h2>功能</h2>
                <el-checkbox disabled checked>发布作业</el-checkbox>
                <br>
                <el-checkbox disabled checked>查看交作业详情</el-checkbox>
                <br>
                <el-checkbox disabled checked>提醒交作业</el-checkbox>
                <br>
                <el-checkbox disabled checked>打包下载</el-checkbox>
                <br>
            </article>
        </div>

    </div>
</template>

<script>
    export default {
        data: function(){
            return {}
        }
    }
</script>

<style scoped>
    .ms-doc{
        width:100%;
        max-width: 980px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
    }
    .ms-doc h3{
        padding: 9px 10px 10px;
        margin: 0;
        font-size: 14px;
        line-height: 17px;
        background-color: #f5f5f5;
        border: 1px solid #d8d8d8;
        border-bottom: 0;
        border-radius: 3px 3px 0 0;
    }
    .ms-doc article{
        padding: 45px;
        word-wrap: break-word;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }
    .ms-doc article h1{
        font-size:32px;
        padding-bottom: 10px;
        margin-bottom: 15px;
        border-bottom: 1px solid #ddd;
    }
    .ms-doc article h2 {
        margin: 24px 0 16px;
        font-weight: 600;
        line-height: 1.25;
        padding-bottom: 7px;
        font-size: 24px;
        border-bottom: 1px solid #eee;
    }
    .ms-doc article p{
        margin-bottom: 15px;
        line-height: 1.5;
    }
    .ms-doc article .el-checkbox{
        margin-bottom: 5px;
    }
</style>
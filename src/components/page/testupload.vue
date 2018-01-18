<template>
    <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-date"></i> 图片管理</el-breadcrumb-item>
                <el-breadcrumb-item>图片上传</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="content-title">图片上传</div>
        <div class="plugins-tips">
            拖拽图片到下边的框内就可以方便的传
            <br>
            支持多文件同时上传
        </div>
        <el-upload
            class="upload-demo"
            drag
            :data='{token:"123123123",work_id:1}'
            action='http://localhost/work-system/api/index.php?_action=upload'
            multiple>
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
            <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过2000kb</div>
        </el-upload>
    </div>
</template>

<script>

    export default {
        data: function(){
            return {
                src: '../../../static/img/img.jpg',
                fileData:{'token':999,'data':123},
                fileList: [],
                upLoadData:{
                    token:"",
                    work_id:1
                }
                
            }
        },
        
        components: {
        },
        methods:{
            imageuploaded(res) {
                console.log(res);

            },
            handleError(){
                this.$notify.error({
                    title: '上传失败',
                    message: '图片上传接口上传失败，可更改为自己的服务器接口'
                });
            }
        }
    }
</script>

<style scoped>
    .content-title{
        font-weight: 400;
        line-height: 50px;
        margin: 10px 0;
        font-size: 22px;
        color: #1f2f3d;
    }
    .pre-img{
        width:250px;
        height: 250px;
        margin-bottom: 20px;
    }
</style>

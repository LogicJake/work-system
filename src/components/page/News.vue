<template>
    <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-setting"></i> 自述</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        
        <div class="ms-doc">
            <h3>通知</h3>
            <el-card v-for="o in 4" class="box-card">
                <div slot="header" class="clearfix">
                    <span>卡片名称</span>
                    <el-button style="float: right; padding: 3px 0" type="text">操作按钮</el-button>
                </div>
                <div v-for="o in 4" :key="o" class="text item">
                    {{'列表内容 ' + o }}
                </div>
            </el-card>
        </div>

    </div>
</template>

<script>
    export default {
        data: function(){
            var works = 'pp';
            this.$ajax.get('http://localhost/work-system/api/index.php?_action=postWork&action_type=getWorks&token='+token
            ).then(re => {
                        //    console.log(re.data);
                            console.log(re);
                            // if(re.data.code == 0){
                            //     localStorage.setItem('has_email',1);
                            //     self.$router.push('/readme');
                            //     location.reload();
                            // }else{
                            //  //    self.$router.push('/readme');
                            //    this.$message.error('邮箱没保存成功~');
                            // }
                        });
            return {}
        }
    }
</script>

<style scoped>
  .text {
    font-size: 14px;
  }

  .item {
    margin-bottom: 18px;
  }

  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }
  .clearfix:after {
    clear: both
  }

  .box-card {
    width: 480px;
  }
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
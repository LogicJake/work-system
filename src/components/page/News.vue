<template>
   <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-setting"></i> 公告</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="ms-doc">
            <h3>作业列表</h3>
                        <article>
            <div :data="works" class="card">
                <el-card  v-for="work in works" :key="work" class="box-card">
                    <div slot="header" class="clearfix">
                        <span>{{ work.work_name}}</span>
                       <div v-if="work.should_upload==true">
                            <div v-if="work.expired==false">
                                <div v-if="work.has_upload==true">
                                    <el-button style="float: right; padding: 3px 0" type="text">已提交</el-button>
                                </div>
                                <div v-if="work.has_upload==false">
                                    <el-button style="float: right; padding: 3px 0" type="text">未提交</el-button>
                                </div>
                            </div>
                            <div v-if="work.expired==true">
                                <el-button class="expire" style="float: right; padding: 3px 0" type="text">已过期</el-button>
                            </div>
                       </div>
                       <div v-if="work.should_upload==false">
                           <el-button style="float: right; padding: 3px 0" type="text">不需要提交</el-button>
                       </div>
                        
                    </div>
                    <div  class="text item">
                        开始时间: {{ (new Date(work.start_time*1000)).Format("yyyy-M-d h:m:s.S") }}
                    </div>
                    <div  class="text item">
                        截止时间: {{ (new Date(work.end_time*1000)).Format("yyyy-M-d h:m:s.S") }}
                    </div>
                    <div  class="text item">
                        提交须知: {{ work.attention_content }}
                    </div>
                    <div  class="text item">
                        允许文件: {{ work.allow_ext }}
                    </div>
                    <div v-if="work.expired==true">
                        <div  class="text item expire">
                            提交时间已过期
                        </div>
                    </div>
                    <div v-if="work.expired==false">
                           
                        <el-collapse accordion>
                            <el-collapse-item>
                                <template slot="title">
                                我要交作业<i class="header-icon el-icon-info"></i>
                                </template>
                                <el-upload
                                    class="upload-demo"
                                    drag
                                    :accept="work.allow_ext"
                                    :data='{work_id:work.id}'
                                    :action= 'uploadUrl'
                                    :on-success= 'imageuploaded'
                                    multiple>
                                    <i class="el-icon-upload"></i>
                                    <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                                    <div class="el-upload__tip" slot="tip">只能上传{{ work.allow_ext }}文件，且不超过2000kb</div>
                                </el-upload>
                            </el-collapse-item>
                        </el-collapse>
                    </div>

                    
                </el-card>
                

            </div>
                        </article>
        </div>

    </div>
</template>
<style>
    .box-card{
        margin: 20px;
    }
    .expire{
        color: red;
    }
     .ms-doc article{
        padding: 45px;
        word-wrap: break-word;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
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
</style>

<script>

// // (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423   
// // (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18   
// Date.prototype.Format = function(fmt)   
// { //author: meizz   
//   var o = {   
//     "M+" : this.getMonth()+1,                 //月份   
//     "d+" : this.getDate(),                    //日   
//     "h+" : this.getHours(),                   //小时   
//     "m+" : this.getMinutes(),                 //分   
//     "s+" : this.getSeconds(),                 //秒   
//     "q+" : Math.floor((this.getMonth()+3)/3), //季度   
//     "S"  : this.getMilliseconds()             //毫秒   
//   };   
//   if(/(y+)/.test(fmt))   
//     fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));   
//   for(var k in o)   
//     if(new RegExp("("+ k +")").test(fmt))   
//   fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
//   return fmt;   
// }  
    export default {
        data() {
            return {
                url: '../../../static/vuetable.json',
                works: [],
                cur_page: 1,
                multipleSelection: [],
                select_cate: '',
                select_word: '',
                activeName: '1',
                token:'',
                uploadUrl:'',
            }
        },
        created(){
            this.token = localStorage.getItem('token');
            this.uploadUrl = '/work-system/api/index.php?_action=upload&token=' + this.token;
            console.log(this.uploadUrl);
            console.log('ppppqweq');
            this.getData();
            //  console.log(this.works);
        },
        methods: {
             imageuploaded(res) {
                console.log(res);
                this.getData();
            },
            handleError(){
                this.$notify.error({
                    title: '上传失败',
                    message: '图片上传接口上传失败，可更改为自己的服务器接口'
                });
            },
            upload(w_id){
                this.activeName = w_id;
            },
            getData(){
                let token = localStorage.getItem('token');
                this.$ajax.get('/work-system/api/index.php?_action=postWork&action_type=getWorks&token='+token,{
                    
                }).then(re => {
                    this.works = re.data.data.works;
                 //   console.log(re.data.data.works);
                   console.log(this.works);
                    console.log('ppp');
                })
            },
             open3() {
                const h = this.$createElement;
        this.$msgbox({
          title: '消息',
          message: h('p', null, [
            h('span', null, '内容可以是 '),
            h('i', { style: 'color: teal' }, 'VNode'),
            h('input',{type:'file'},'')
          ]),
          showCancelButton: true,
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          beforeClose: (action, instance, done) => {
            if (action === 'confirm') {
              instance.confirmButtonLoading = true;
              instance.confirmButtonText = '执行中...';
              setTimeout(() => {
                done();
                setTimeout(() => {
                  instance.confirmButtonLoading = false;
                }, 300);
              }, 3000);
            } else {
              done();
            }
          }
        }).then(action => {
          this.$message({
            type: 'info',
            message: 'action: ' + action
          });
        });

      }
           
        }
    }
</script>

<style scoped>
.handle-box{
    margin-bottom: 20px;
}
.handle-del{
    border-color: #bfcbd9;
    color: #999;
}
.handle-select{
    width: 120px;
}
.handle-input{
    width: 300px;
    display: inline-block;
}
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
</style>

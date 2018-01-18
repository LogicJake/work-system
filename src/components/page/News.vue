<template>
   <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-setting"></i> 自述</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="ms-doc">
            <h3>README.md</h3>
            <div :data="works" class="card">
                <el-card  v-for="work in works" :key="work" class="box-card">
                    <div slot="header" class="clearfix">
                        <span>{{ work.work_name}}</span>
                        <el-button style="float: right; padding: 3px 0" type="text">操作按钮</el-button>
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
                </el-card>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                url: '../../../static/vuetable.json',
                works: [],
                cur_page: 1,
                multipleSelection: [],
                select_cate: '',
                select_word: ''
            }
        },
        created(){
            this.getData();
            //  console.log(this.works);
        },
        methods: {
            getData(){
                let token = localStorage.getItem('token');
                this.$ajax.get('http://localhost/work-system/api/index.php?_action=postWork&action_type=getWorks&token='+token,{
                    
                }).then(re => {
                    this.works = re.data.data.works;
                 //   console.log(re.data.data.works);
                   console.log(this.works);
                    console.log('ppp');
                })
            },
           
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

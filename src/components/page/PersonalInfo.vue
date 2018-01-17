<template>
    <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-date"></i>作业</el-breadcrumb-item>
                <el-breadcrumb-item>个人信息</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="form-box">
         
            <el-form :model="work_form" :rules="work_form_rules" ref="work_form" label-width="80px">
                <!-- <el-form-item  prop="name" label="姓名">
                    <el-input v-model="work_form.name"></el-input>
                </el-form-item> -->
                <el-form-item  prop="email" label="邮箱">
                    <el-input v-model="work_form.email"></el-input>
                </el-form-item>
                 <el-form-item>
                    <el-button type="primary" @click="onSubmit('work_form')">提交</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>
        </div>

    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                work_form: {
                    email: ''
                },
                work_form_rules: {
                    email: [
                        { required: true, message: '请输入邮箱', trigger: 'blur' }
                    ]
                   
                }
            }
        },
        methods: {
            onSubmit(formName) {
                const self = this;
                console.log(this);
                let token = localStorage.getItem('token');
                console.log(token);
                var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (filter.test(this.work_form.email))
                {
                     self.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$ajax.post('http://localhost/work-system/api/index.php?_action=getPersonalInfo&action_type=saveEmail&token='+token,{
                            'email': this.work_form.email
                        }).then(re => {
                        //    console.log(re.data);
                            console.log(re);
                            if(re.data.code == 0){
                                localStorage.setItem('has_email',1);
                                self.$router.push('/readme');
                                location.reload();
                            }else{
                             //    self.$router.push('/readme');
                               this.$message.error('邮箱没保存成功~');
                            }
                        })
                        
                    }
                });
                }
                else {
                       alert('您的电子邮件格式不正确');

                }
             

               
            }
        }
    }
</script>
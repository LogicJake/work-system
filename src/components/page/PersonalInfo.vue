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
                <div v-if="has_email==true&&change==false">
                    <el-form-item  prop="email" label="邮箱">
                        <el-input v-model="work_form.email" :disabled="true"></el-input>
                        <el-button @click="change=true;work_form.email=''">修改</el-button>
                    </el-form-item>

                </div>
                <div v-if="has_email==false||change==true">
                    <el-form-item  prop="email" label="邮箱">
                        <el-input v-model="work_form.email"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSubmit('work_form')">提交</el-button>
                        <el-button>取消</el-button>
                    </el-form-item>
                    <el-form-item  prop="email_verifycode" label="验证码">
                        <el-input v-model="work_form.email_verifycode"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSubmit_code('work_form')">提交</el-button>
                        <el-button>取消</el-button>
                    </el-form-item>
                </div>
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
                   
                },
                change:true,
                has_email:false,
                email:'',
                checkEmailUrl:''
            }
        },
        created(){
            this.token = localStorage.getItem('token');
            this.checkEmailUrl = this.$domin+'/work-system/api/index.php?_action=verifyMailbox&action_type=getMail&token=' + this.token;
            console.log('ppppqweq');
            this.getData();
            //  console.log(this.works);
        },
        methods: {
            getData(){
                this.$ajax.get(this.checkEmailUrl).then(re=>{
                    console.log(re);
                    if(re.data.code==0)
                    {
                        this.email=re.data.data;
                        this.work_form.email=re.data.data;
                        this.has_email=true;
                        this.change=false;
                    }
                });
                console.log(this.work_form);

            },
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
                        this.$ajax.get(this.$domin+'/work-system/api/index.php?_action=verifyMailbox&action_type=sendCode&token='+token+'&mail='+this.work_form.email  
                        ).then(re => {
                        //    console.log(re.data);
                            console.log(re);
                            if(re.data.code == 0){
                                this.$message.success('验证码已发至邮箱~');

                                // localStorage.setItem('has_email',1);
                                // self.$router.push('/readme');
                                // location.reload();
                            }else{
                             //    self.$router.push('/readme');
                               this.$message.error('验证码发送失败~');
                            }
                        })
                        
                    }
                });
                }
                else {
                       alert('您的电子邮件格式不正确');

                }
             

               
            },
            onSubmit_code(formName) {
                const self = this;
                console.log(this);
                let token = localStorage.getItem('token');
                console.log(token);
                // var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                // if (filter.test(this.work_form.email_verifycode))
                // {
                    //  self.$refs[formName].validate((valid) => {
                    // if (valid) {
                        this.$ajax.get(this.$domin+'/work-system/api/index.php?_action=verifyMailbox&action_type=verifyCode&token='+token+'&code='+this.work_form.email_verifycode
                        ).then(re => {
                        //    console.log(re.data);
                            console.log(re);
                            if(re.data.code == 0){
                                localStorage.setItem('has_email',1);
                                this.$message.success('邮箱修改成功');
                                this.change=false;
                                this.has_email=true;
                                // self.$router.push('/readme');
                                // location.reload();
                            }else{
                             //    self.$router.push('/readme');
                               this.$message.error('邮箱没保存成功~');
                            }
                        });
                        
                //     }
                // });
                // }
                // else {
                //        alert('您的电子邮件格式不正确');

                // }
             

               
            }
        }
    }
</script>
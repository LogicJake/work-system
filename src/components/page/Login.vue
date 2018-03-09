<template>
    <div class="login-wrap">
        <div class="ms-title">作业提交系统</div>
        <div class="ms-login">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="0px" class="demo-ruleForm">
                <el-form-item prop="username">
                    <el-input v-model="ruleForm.username" placeholder="username"></el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input type="password" placeholder="password" v-model="ruleForm.password" @keyup.enter.native="submitForm('ruleForm')"></el-input>
                </el-form-item>
                <div class="login-btn">
                    <el-button type="primary" @click="submitForm('ruleForm')">登录</el-button>
                </div>
                <p style="font-size:12px;line-height:30px;color:#999;">Tips : 用户名和密码随便填。</p>
            </el-form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                ruleForm: {
                    username: '',
                    password: ''
                },
                rules: {
                    username: [
                        { required: true, message: '请输入用户名', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            submitForm1(formName) {
                const self = this;
                self.$refs[formName].validate((valid) => {
                    if (valid) {
                        localStorage.setItem('ms_username',self.ruleForm.username);
                        self.$router.push('/readme');
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            submitForm(formName) {
                const self = this;
                console.log(this);
                self.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$ajax.get('/api/index.php?_action=postLogin&action_type=login&user='+this.ruleForm.username+'&passwd='+this.ruleForm.password,{
                            // 'user': this.ruleForm.username,
                            // 'passwd': this.ruleForm.password
                        }).then(re => {
                            console.log(re);
                            console.log('pp');
                            if(re.data.code == 0){
                                localStorage.setItem('ms_username',re.data.data.user_name);
                                localStorage.setItem("token",re.data.data.token);
                                localStorage.setItem("has_email",1);
                                console.log(re.data);
                                var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                                if (filter.test(re.data.data.email))
                                {
                                    // self.$router.push('/personalinfo');
                                   self.$router.push('/readme');
                                }
                                else
                                {
                                    localStorage.setItem("has_email",0);
                                    self.$router.push('/personalinfo');
                                }
                               
                            }else{console.log(re.data);
                             ///   self.$router.push('/readme');
                               this.$message.error('似乎密码出现了错误~');
                            }
                        });
                        
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .login-wrap{
        position: relative;
        width:100%;
        height:100%;
    }
    .ms-title{
        position: absolute;
        top:50%;
        width:100%;
        margin-top: -230px;
        text-align: center;
        font-size:30px;
        color: #fff;

    }
    .ms-login{
        position: absolute;
        left:50%;
        top:50%;
        width:300px;
        height:160px;
        margin:-150px 0 0 -190px;
        padding:40px;
        border-radius: 5px;
        background: #fff;
    }
    .login-btn{
        text-align: center;
    }
    .login-btn button{
        width:100%;
        height:36px;
    }
</style>
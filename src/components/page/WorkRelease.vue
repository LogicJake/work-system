<template>
    <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-date"></i>作业</el-breadcrumb-item>
                <el-breadcrumb-item>作业发布</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="form-box">
         
            <el-form :model="work_form" :rules="work_form_rules" ref="work_form" label-width="80px">
                <el-form-item  prop="name" label="作业名称">
                    <el-input v-model="work_form.name"></el-input>
                </el-form-item>
                <el-form-item prop="region" label="需提交者">
                    <el-select v-model="work_form.region" placeholder="请选择">
                        <el-option key="1615402" label="1615402" value="1615402"></el-option>
                        <el-option key="1615403" label="1615403" value="1615403"></el-option>
                        <el-option key="1615401" label="1615401" value="1615401"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item prop="start_time" label="日期时间">
                    <el-col :span="11">
                        <el-date-picker type="datetime" placeholder="开始时间" v-model="work_form.start_time" style="width: 100%;"></el-date-picker>
                    </el-col>
                    <el-col class="line" :span="2">-</el-col>
                    <el-col :span="11">
                        <el-date-picker type="datetime" placeholder="截止时间" v-model="work_form.end_time" style="width: 100%;"></el-date-picker>
                    </el-col>
                </el-form-item>
                <el-form-item prop="end_time" label="通知所有">
                    <el-switch on-text="" off-text="" v-model="work_form.inform_all"></el-switch>
                </el-form-item>
                <el-form-item prop="inform_all" label="允许文件">
                    <el-checkbox-group v-model="work_form.type">
                        <el-checkbox label="docx" name="type"></el-checkbox>
                        <el-checkbox label="zip" name="type"></el-checkbox>
                        <el-checkbox label="rar" name="type"></el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <el-form-item prop="type" label="单选框">
                    <el-radio-group v-model="work_form.resource">
                        <el-radio label="步步高"></el-radio>
                        <el-radio label="小天才"></el-radio>
                        <el-radio label="imoo"></el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item prop="should_know" label="提交须知">
                    <el-input type="textarea" v-model="work_form.should_know"></el-input>
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
                    name: '',
                    region: '',
                    start_time: '',
                    end_time: '',
                    inform_all: true,
                    type: ['zip'],
                    resource: '小天才',
                    should_know: ''
                },
                work_form_rules: {
                    name: [
                        { required: true, message: '请输入作业名', trigger: 'blur' }
                    ],
                    region: [
                        { required: true, message: '请输入需提交者', trigger: 'blur' }
                    ],
                    start_time: [
                        { required: true, message: '请输入时间', trigger: 'blur' }
                    ],
                    end_time: [
                        { required: true, message: '请输入时间', trigger: 'blur' }
                    ],
                    inform_all: [
                        { required: true, message: '请输入是否通知所有', trigger: 'blur' }
                    ],
                    type: [
                        { required: true, message: '请输入上传类型', trigger: 'blur' }
                    ],
                    resource: [
                        { required: true, message: '请输入xxx', trigger: 'blur' }
                    ],
                    should_know: [
                        { required: true, message: '请输入作业须知', trigger: 'blur' }
                    ]
                   
                }
            }
            
        },
        methods: {
            onSubmit(formName) {
                const self = this;
                console.log(this);
                self.$refs[formName].validate((valid) => {
                    if (valid) {
                        // this.$ajax.post('http://localhost/work-system/api/login.php?action=login',{
                        //     'user': this.rule_Form.username,
                        //     'passwd': this.rule_Form.password
                        // }).then(re => {
                        //     console.log(re.data);
                        //     console.log(re);
                        //     if(re.data.code == 0){
                        //         localStorage.setItem('ms_username',self.rule_Form.username);
                        //         self.$router.push('/readme');
                        //     }else{
                        //          self.$router.push('/readme');
                        //         this.$message.error('似乎密码出现了错误~');
                        //     }
                        // })
                        
                    }
                });
            }
        }
    }
</script>
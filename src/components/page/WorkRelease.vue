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
                <el-form-item  prop="work_name" label="作业名称">
                    <el-input v-model="work_form.work_name"></el-input>
                </el-form-item>
                <el-form-item prop="target_group" label="需提交者">
                    <!-- <el-checkbox-group v-model="work_form.target_group">
                        <el-checkbox label="1615402" name="target_group"></el-checkbox>
                        <el-checkbox label="1615403" name="target_group"></el-checkbox>
                        <el-checkbox label="1615401" name="target_group"></el-checkbox>
                    </el-checkbox-group> -->
                    <el-checkbox-group v-model="work_form.target_group">
                        <el-checkbox label="1615402" name="target_group"></el-checkbox>
                        <el-checkbox label="1615403" name="target_group"></el-checkbox>
                        <el-checkbox label="1615401" name="target_group"></el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <el-form-item prop="time" label="日期时间">
                    <el-col :span="11">
                        <el-date-picker type="datetime" prop="start_time" placeholder="开始时间" v-model="work_form.start_time" style="width: 100%;"></el-date-picker>
                    </el-col>
                    <el-col class="line" :span="2">-</el-col>
                    <el-col :span="11">
                        <el-date-picker type="datetime" prop="end_time" placeholder="截止时间" v-model="work_form.end_time" style="width: 100%;"></el-date-picker>
                    </el-col>
                </el-form-item>
                <el-form-item prop="inform_all" label="通知所有">
                    <el-switch on-text="" off-text="" v-model="work_form.inform_all"></el-switch>
                </el-form-item>
                <el-form-item prop="allow_ext" label="允许文件">
                    <el-checkbox-group v-model="work_form.allow_ext">
                        <el-checkbox label="docx" name="allow_ext"></el-checkbox>
                        <el-checkbox label="zip" name="allow_ext"></el-checkbox>
                        <el-checkbox label="rar" name="allow_ext"></el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <!-- <el-form-item prop="type" label="单选框">
                    <el-radio-group v-model="work_form.resource">
                        <el-radio label="步步高"></el-radio>
                        <el-radio label="小天才"></el-radio>
                        <el-radio label="imoo"></el-radio>
                    </el-radio-group>
                </el-form-item> -->
                <el-form-item prop="attention_content" label="提交须知">
                    <el-input type="textarea" v-model="work_form.attention_content"></el-input>
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
                    work_name: '',
                    target_group: ['1615402','1615403'],
                    start_time: '',
                    end_time: '',
                    inform_all: true,
                    allow_ext: ['zip'],
                    // resource: '小天才',
                    attention_content: ''
                },
                work_form_rules: {
                    work_name: [
                        { required: true, message: '请输入作业名', trigger: 'blur' }
                    ],
                    // target_group: [
                    //     { required: true, message: '请输入需提交者', trigger: 'blur' }
                    // ],
                    // allow_ext: [
                    //     { required: true, message: '请输入上传类型', trigger: 'blur' }
                    // ],
                    // resource: [
                    //     { required: true, message: '请输入xxx', trigger: 'blur' }
                    // ],
                    attention_content: [
                        { required: true, message: '请输入作业须知', trigger: 'blur' }
                    ]
                   
                }
            }
            
        },
        methods: {
            onSubmit(formName) {
                const self = this;
                console.log(this);
                console.log(Date.parse(new Date(this.work_form.start_time))/1000);
                console.log(Date.parse(this.work_form.start_time));
                console.log(this.work_form.start_time);
                let token = localStorage.getItem('token');
                // Date.parse(this.start_time);
                
                self.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$ajax.post('http://localhost/work-system/api/index.php?_action=postWork&action_type=releaseNewwork&token='+token,{
                            'work_name': this.work_form.work_name,
                            'target_group': this.work_form.target_group.join("-"),
                            'start_time': Date.parse(new Date(this.work_form.start_time))/1000,
                            'end_time': Date.parse(new Date(this.work_form.end_time))/1000,
                            'inform_all': this.work_form.inform_all,
                            'allow_ext': this.work_form.allow_ext.join("-"),
                            'attention_content': this.work_form.attention_content
                        }).then(re => {
                            console.log(re.data);
                            console.log(re);
                            if(re.data.code == 0){
                                //localStorage.setItem('ms_username',self.rule_Form.username);
                                self.$router.push('/news');
                                this.$message.success('作业发布成功');
                            }else{
                                 //self.$router.push('/readme');
                                this.$message.error('发布作业失败~');
                            }
                        })
                        
                    }
                });
            }
        }
    }
</script>
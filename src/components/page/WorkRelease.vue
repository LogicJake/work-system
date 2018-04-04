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
                    <!-- Form -->

                    <el-button type="text" @click="dialogFormVisible = true ;getAllteamname()"> 自定义提交成员 </el-button>
                    <el-tag
                        type="success"
                        :key="tag"
                        v-for="tag in work_form.target_stu"
                        closable
                        :disable-transitions="false"
                        @close="handleClose(tag)"
                    >
                    {{tag}}
                    </el-tag>
                    <el-input
                        class="input-new-tag"
                        v-if="inputVisible"
                        v-model="inputValue"
                        ref="saveTagInput"
                        size="small"
                        @keyup.enter.native="handleInputConfirm"
                        @blur="handleInputConfirm"
                    >
                    </el-input>
                    <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>

                </el-form-item>
                <el-dialog title="选择team" :visible.sync="dialogFormVisible">

    <!-- <el-form-item label="活动名称" :label-width="formLabelWidth">
      <el-input v-model="work_form.teamname" auto-complete="off"></el-input>
    </el-form-item> -->
    <el-form-item label="选择team" :label-width="formLabelWidth">
      <el-select v-model="work_form.teamname" placeholder="请选择team" @change="getByteam">
          <!-- <el-select  v-model="select_cate" placeholder="作业id" @change="selectionchange" class="handle-select mr10">
                <el-option v-for="work in work_ids" :key="work.id" :label="work.work_name" :value="work.id"></el-option>
            </el-select> -->
        <el-option v-for="name in Allteamname" :key="name"   :label="name" :value="name"></el-option>
      </el-select>
       <el-checkbox-group v-model="work_form.target_stu">
                <el-checkbox v-for="stu in Allstu" :key="stu.stu_num"  :label="stu.stu_num" name="target_stu"></el-checkbox>
        </el-checkbox-group>
    </el-form-item>
  <div slot="footer" class="dialog-footer">
    <el-button @click="dialogFormVisible = false">取 消</el-button>
    <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
  </div>
</el-dialog>
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
                checkList:[],
                inputVisible: false,
                inputValue: '',

                dialogTableVisible: false,
                dialogFormVisible: false,
                Allteamname:['pp'],
                formLabelWidth: '120px',
                Allstu:['161540205'],
                work_form: {
                    work_name: '',
                    target_group: ['1615402','1615403'],
                    start_time: '',
                    end_time: '',
                    inform_all: true,
                    allow_ext: ['zip'],
                    target_stu:[],
                    // resource: '小天才',
                    attention_content: '',
                   
                   
                    teamname:'',
                    has_allteamname:0
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
            showInput() {
                this.inputVisible = true;
                this.$nextTick(_ => {
                this.$refs.saveTagInput.$refs.input.focus();
                });
            },
            handleInputConfirm() {
                let inputValue = this.inputValue;
                if (inputValue) {
                this.work_form.target_stu.push(inputValue);
                }
                this.inputVisible = false;
                this.inputValue = '';
            },
            handleClose(tag) {
                this.work_form.target_stu.splice(this.work_form.target_stu.indexOf(tag), 1);
            },
            getByteam(){
                const self = this;

                let token = localStorage.getItem('token');
                this.dialogFormVisible = true ;
 
                    this.$ajax.post(this.$domin+'/work-system/api/index.php?_action=team&action_type=getbyteam&token='+token+"&teamname="+self.work_form.teamname,{
                        "teamname":self.work_form.teamname
                    }).then(re => {
                        console.log(re.data);
                        console.log(re);
                        if(re.data.code == 0){
                            self.Allstu = re.data.data;
                        }else{
                            this.$message.error('没有分组~');
                        }
                    });
                
            },
            getAllteamname(){
                const self = this;

                let token = localStorage.getItem('token');
                this.dialogFormVisible = true ;
 
                    this.$ajax.post(this.$domin+'/work-system/api/index.php?_action=team&action_type=getallteam&token='+token).then(re => {
                        console.log(re.data);
                        console.log(re);
                        if(re.data.code == 0){
                            self.Allteamname = re.data.data;
                            self.work_form.has_allteamname = 1;
                        }else{
                            this.$message.error('没有分组~');
                        }
                    });
                
            },
            onSubmit(formName) {
                const self = this;
                // console.log(this);
                // console.log(Date.parse(new Date(this.work_form.start_time))/1000);
                // console.log(Date.parse(this.work_form.start_time));
                console.log(this.work_form);
                let token = localStorage.getItem('token');
                // Date.parse(this.start_time);
                var myDate = new Date();
                console.log(myDate.getYear());        //获取当前年份(2位)
                console.log(myDate.getFullYear());    //获取完整的年份(4位,1970-????)
                console.log(myDate.getMonth());       //获取当前月份(0-11,0代表1月)
                console.log(myDate.getDate()); 
                var target_group_name = ''+ myDate.getFullYear() + '_' + myDate.getMonth() + '_' + myDate.getDate() + '_' + this.work_form.work_name;
                var new_work_name = ''+ myDate.getFullYear() + '_' + myDate.getMonth() + '_' + myDate.getDate() + '_' + this.work_form.work_name;
                self.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log(this.$domin);
                        this.$ajax.post(this.$domin+'/work-system/api/index.php?_action=postWork&action_type=releaseNewwork&token='+token,{
                            'work_name': new_work_name,//this.work_form.work_name,
                            'target_group': target_group_name,//this.work_form.target_group.join("-"),
                            'start_time': Date.parse(new Date(this.work_form.start_time))/1000,
                            'end_time': Date.parse(new Date(this.work_form.end_time))/1000,
                            'inform_all': this.work_form.inform_all,
                            'allow_ext': this.work_form.allow_ext.join("-"),
                            'attention_content': this.work_form.attention_content,
                            "target_user_nums": this.work_form.target_stu
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

<style>
  .el-tag + .el-tag {
    margin-left: 10px;
  }
</style>

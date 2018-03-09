<template>
    <div class="table">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-menu"></i> 表格</el-breadcrumb-item>
                <el-breadcrumb-item>基础表格</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="handle-box">
            <el-button type="primary" icon="el-icon-download" class="handle-del mr10" @click="downloadAll">批量下载(未上传作业自动提醒)</el-button>
            <el-select  v-model="select_cate" placeholder="作业id" @change="selectionchange" class="handle-select mr10">
                <el-option v-for="work in work_ids" :key="work.id" :label="work.work_name" :value="work.id"></el-option>
                <!-- <el-option key="2" label="湖南省" value="湖南省"></el-option> -->
            </el-select>
            <el-input v-model="select_word" placeholder="筛选关键词" class="handle-input mr10"></el-input>
            <el-button type="primary" icon="search" @click="search">搜索</el-button>
        </div>
        <el-table :data="data" border style="width: 100%" ref="multipleTable" @selection-change="handleSelectionChange">
            <el-table-column type="selection" width="55"></el-table-column>
            <el-table-column prop="user_id" label="user_id">
            </el-table-column>
            <el-table-column prop="stu_num" label="学号" sortable width="150">
            </el-table-column>
            <el-table-column prop="stu_name" label="姓名" sortable width="150">
            </el-table-column>
            <el-table-column prop="add_time" label="提交时间" sortable width="150">
            </el-table-column>
            <!-- <el-table-column prop="has_uplaod" label="是否已提交" sortable width="150">
            </el-table-column> -->
            <el-table-column prop="提醒提交" label="提醒提交" width="120">
            </el-table-column>
            <el-table-column label="操作" width="180">
                <template scope="scope">
                    <el-button size="small"
                            @click="remind(scope.$index,scope.row)">提醒</el-button>
                    <el-button size="small"
                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button size="small" type="danger"
                            @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="pagination">
            <el-pagination
                    @current-change ="handleCurrentChange"
                    layout="prev, pager, next"
                    :total="1000">
            </el-pagination>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import JSZip from 'jszip'
import FileSaver from 'file-saver'

const getFile = url => {
    return new Promise((resolve, reject) => {
        axios({
            method:'get',
            url,
            responseType: 'arraybuffer'
        }).then(data => {
            resolve(data.data)
        }).catch(error => {
            reject(error.toString())
        })
    })
}

    export default {
        data() {
            return {
                url: '',
                workidurl: '',
                tableData: [],
                token:'',
                cur_page: 1,
                multipleSelection: [],
                select_cate: '',
                select_word: '',
                del_list: [],
                is_search: false,
                work_id:'6',
                work_name:'',
                target_group:'1615403',
                work_ids:[],
                byworkid:'',
                remindoneurl:''
            }
        },
        created(){
            this.token = localStorage.getItem('token');
            this.url = '/api/index.php?_action=admin&action_type=get_upload_by_group&target_group=1615403&token='+this.token;
            this.workidurl = '/api/index.php?_action=admin&action_type=get_work_ids&token='+this.token;
            this.byworkid = '/api/index.php?_action=admin&action_type=get_upload_by_group&token='+this.token;
//            this.getData();
            this.remindoneurl = '/api/index.php?_action=admin&token='+this.token;
            this.getWorkids();
        },
        computed: {
            data(){
                const self = this;
                return self.tableData.filter(function(d){
                    console.log(d);
                    
                    // let is_del = false;
                    // for (let i = 0; i < self.del_list.length; i++) {
                    //     if(d.name === self.del_list[i].name){
                    //         is_del = true;
                    //         break;
                    //     }
                    // }
                    // if(!is_del){
                    //     if(d.address.indexOf(self.select_cate) > -1 && 
                    //         (d.name.indexOf(self.select_word) > -1 ||
                    //         d.address.indexOf(self.select_word) > -1)
                    //     ){
                    //         return d;
                    //     }
                    // }
                    if(d.has_upload==1)
                    {
                        d.add_time =  (new Date(d.add_time*1000)).Format("yyyy-M-d h:m:s.S");
                    }
                    else
                    {
                        d.add_time = '未提交';
                    }
                    return d;
                })
            }
        },
        methods: {
            remind(user_id,tablerowdata){
                let self = this;
                console.log(tablerowdata['user_id']);
                var user_id = tablerowdata['user_id'];
                var url = this.remindoneurl+'&action_type=remind_one&work_id='+this.work_id+'&user_id='+user_id;
                console.log(url);
                self.$axios.post(url, {page:self.cur_page}).then((res) => {
                    // self.tableData = res.data.data;
                    console.log(res);
                   // console.log(self.tableData);
                });
                console.log(user_id);
            },
            selectionchange(val){
                console.log('ppppp  change');
                console.log(val);
                this.work_id = val;
                var work = this.work_ids.find(function (obj) {
                            return obj.id == val;
                        });
                this.work_name = work['work_name'];
                console.log(this.work_name);
                this.getDataByWorkid(val);
                
            },
            getDataByWorkid(work_id){
                let self = this;
                if(process.env.NODE_ENV === 'development'){
                    // self.url = '/ms/table/list';
                };
                var byworkidurl = this.byworkid + '&work_id=' + work_id;
                console.log(work_id);
                console.log(byworkidurl);
                self.$axios.post(byworkidurl, {page:self.cur_page}).then((res) => {
                    self.tableData = res.data.data;
                    console.log(res);
                    console.log(self.tableData);
                })
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                let self = this;
                if(process.env.NODE_ENV === 'development'){
                    // self.url = '/ms/table/list';
                };
                self.$axios.post(self.url, {page:self.cur_page}).then((res) => {
                    self.tableData = res.data.data;
                    console.log(res);
                    console.log(self.tableData);
                })
            },
            getWorkids() {
                 let self = this;
                if(process.env.NODE_ENV === 'development'){
                    // self.url = '/ms/table/list';
                };
                self.$axios.post(self.workidurl, {page:self.cur_page}).then((res) => {
                    self.work_ids = res.data.data;
                    console.log(self.work_ids);
                })
            },
            search(){
                this.is_search = true;
            },
            // formatter(row, column) {
            //     return row.address;
            // },
            // filterTag(value, row) {
            //     return row.tag === value;
            // },
            handleEdit(index, row) {
                this.$message('编辑第'+(index+1)+'行');
            },
            handleDelete(index, row) {
                this.$message.error('删除第'+(index+1)+'行');
            },
            delAll(){
                const self = this,
                    length = self.multipleSelection.length;
                let str = '';
                self.del_list = self.del_list.concat(self.multipleSelection);
                for (let i = 0; i < length; i++) {
                    str += self.multipleSelection[i].name + ' ';
                }
                self.$message.error('删除了'+str);
                self.multipleSelection = [];
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
                console.log(val);
                console.log('handle selection change');
            },
            downloadAll(){
                var val = this.multipleSelection;
                var to_download = [];
                val.forEach(to_d => {
                    if(to_d['has_upload']==1)
                    {
                        var new_to_d = '/api/upload/'+this.work_id+'/'+to_d['file_name'];
                        to_download.push(new_to_d);
                    }
                    else
                    {
                        this.remind(to_d['user_id'],to_d);
                    }
                    
                });
                const data = to_download // 需要下载打包的路径, 可以是本地相对路径, 也可以是跨域的全路径
                const zip = new JSZip()
                const cache = {}
                const promises = []
                data.forEach(item => {
                    const promise = getFile(item).then(data => { // 下载文件, 并存成ArrayBuffer对象
                        const arr_name = item.split("/")
                        const file_name = arr_name[arr_name.length - 1] // 获取文件名
                        zip.file(file_name, data, { binary: true }) // 逐个添加文件
                        cache[file_name] = data
                    })
                    promises.push(promise)
                })

                Promise.all(promises).then(() => {
                    zip.generateAsync({type:"blob"}).then(content => { // 生成二进制流
                        FileSaver.saveAs(content,  this.work_name +".zip") // 利用file-saver保存文件
                    })
                })
            }
        }
    }
</script>

<style scoped>
.handle-box{
    margin-bottom: 20px;
}
.handle-select{
    width: 120px;
}
.handle-input{
    width: 300px;
    display: inline-block;
}
</style>
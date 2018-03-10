<template>
    <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-date"></i> 表单</el-breadcrumb-item>
                <el-breadcrumb-item>markdown</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="plugins-tips">
            Vue-SimpleMDE：Vue.js的Markdown Editor组件。
            访问地址：<a href="https://github.com/F-loat/vue-simplemde" target="_blank">Vue-SimpleMDE</a>
        </div>
        <markdown-editor v-model="content" :configs="configs" ref="markdownEditor"></markdown-editor>
        <div class="plugins-tips">
            <p>既然用了markdown语法了，那么就有一个很实际的问题了。要怎么在前台展示数据呢？</p>
            <br>
            <p>这个时候就需要解析markdown语法了。可以使用 <a href="https://github.com/miaolz123/vue-markdown" target="_blank">vue-markdown</a>：一个基于vue.js的markdown语法解析插件。（这里不作展开，有需要自行了解）</p>
        </div>
        <div>
            <button type="submit" @click="handleBatchDownload">下载</button>
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
    // render(h) {
    //     return (<a on-click={ () => this.handleBatchDownload() } href="javascript:;">批量下载</a>)
    // },
    methods: {
        handleBatchDownload() {
            const data = ['/work-system/api/upload/123.jpg'] // 需要下载打包的路径, 可以是本地相对路径, 也可以是跨域的全路径
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
                    FileSaver.saveAs(content, "打包下载.zip") // 利用file-saver保存文件
                })
            })
        },
    },
}

</script>
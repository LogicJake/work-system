# 接口

## 登陆
| 名称 | 选项 |
|:---:|:---:|
| 接口地址 | /index.php?_action=postDedlogin|
| 支持格式 | JSON,JSONP
| 请求方法 | GET
| 请求示例 | http://localhost/work-system/api/index.php?_action=postLogin&action_type=login&user=161540205&passwd=123456

### 返回
#### 成功
```
{
    "code":0,
    "data":{
        "id":"2",
        "user_name":"默认姓名",
        "user_num":"161540205",
        "token":"7e3951c821d4d171c0a084d57e826aef",
        "status":1
        }
}
```
#### 失败
```
{
    "code":1,
    "msg":"check failed"
}
```

***

## 发送验证码
| 名称 | 选项 |
|:---:|:---:|
| 接口地址 | /index.php?_action=verfyMailbox|
| 支持格式 | JSON,JSONP
| 请求方法 | GET
| 请求示例 | http://localhost/work-system/api/index.php?_action=verifyMailbox&action_type=sendCode&token=7b04b993df34c7a895e2b5787aa4840a&mail=83541****@qq.com

### 返回
#### 成功
```
{
  "code": 0,
  "data": "send success"
}
```
#### 失败
```
{
  "code": 1,
  "data": "send failed"
}
```
***


## 验证验证码
| 名称 | 选项 |
|:---:|:---:|
| 接口地址 | /index.php?_action=verfyMailbox|
| 支持格式 | JSON,JSONP
| 请求方法 | GET
| 请求示例 | http://localhost/work-system/api/index.php?_action=verifyMailbox&action_type=verifyCode&token=7b04b993df34c7a895e2b5787aa4840a&code=m3a8

### 返回
#### 成功
```
{
  "code": 0,
  "data": "success"
}
```
#### 失败
```
{
  "code": 0,
  "data": "fail"
}
```

***
# Note: This is a customized version!


# 原始文档
https://github.com/mitulgolakiya/laravel-api-generator

# 使用

## php artisan

命令行执行

```sh
php artisan

# 可以看到有这三个可用的，一般我们用第二个，不需要生成 api
# mitul.generator
mitul.generator:api                       # Create a full CRUD API for given model
mitul.generator:scaffold                  # Create a full CRUD for given model with initial
mitul.generator:scaffold_api              # Create a full CRUD for given model with initial views and APIs

# 这后面可以带 —-softDelete，生成的 model 会自己维护删除字段，很好用

# 执行第二个命令，后面带参数 ModelName 即 model 名，不一定要和数据库表名一样，比如邮件服务器的错误表，model 名是 GmailError，Laravel 的 model 通常后面不带 s
php artisan mitul.generator:scaffold ModelName

# 然后会让你输入定义 model 字段的文件，默认是项目根的 model.txt，你也可以输入自己的，不然直接留空回车

# Specify [fields describtion file name] for the model (skip id & timestamp fields, will be added automatically)
# Doc: http://laravel.com/docs/5.0/schema
File(Default:model.txt):

# 然后会输出一些信息

#然后有两个问题：

Do you want to generate repository ? (y|N)
Do you want to migrate database? [y|N]

# 通常都输入 n 回车。
# repository 是对 model 又一层封装，咱们暂时不需要
# migrate 是数据库迁移，如果是已经存在的库，不需要
# 如果是新的库，就选 y，也就是说，不需要到 mysql 创建数据库，能够根据 model.txt 自动创建

```

## 生成好了后
1. 到生成的 model 文件

```php
# 修改数据库配置
protected $connection = '';

# 自动生成的 rules 有些是不支持的，比如 default，如果出错在这里清理一下
public static $rules = [
    "type" => "required",
     "priority" => "unique:errors|required",
     "error_code" => "unique:errors|required"
];

# 可选修改 search 相关变量
protected $searchable = [
];
```

## 在项目根目录创建 model.txt

空格分为三栏

1. 字段名
2. 类型和参数 (参考 http://www.golaravel.com/laravel/docs/5.0/schema/)
3. 验证规则 (参考 http://www.golaravel.com/laravel/docs/5.0/validation/)

```
type enum,["dynamic","static"] required|default:dynamic
priority interger,11 unique:errors|required
error_code interger,11 unique:errors|required
error_name string,100
error_display string,1000
error_display_color string,100
remarks string,1000
handler string,100
```

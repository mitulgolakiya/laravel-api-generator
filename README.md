## Note: This is a customized version!


## 原始文档
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

#然后有几个问题(直接空格就是 N)：

# 数据库连接
DB_CONNECTION: gmail
# 表名称
DB_TABLE_NAME: blacklist
# laravel 可以自动维护这两个字段，所以新库就用这个功能，旧库一般没有
Does table has created_at and updated_at columns ? (Y|N)
# 是否启用 laravel softDelete 功能，同理，旧库一般没有
# 但是建议在数据库添加 deleted_at(timestamp) 字段，这样删除就安全了，但是要注意是否会影响其它应用
Do you want to use softDelete (need a deleted_at column at table, no need set in model.txt)? (Y|N) y
# 列表页搜索组件是否启用日期范围选择器，如果都没有时间相关字段，就不启用了
Do you want to use dateranger plugin with search? (Y|N)

# repository 是对 model 又一层封装，咱们暂时不需要，直接回车
Do you want to generate repository ? (Y|N)
# migrate 是数据库迁移，如果是已经存在的库，不需要
# 如果是新的库，就选 y，也就是说，不需要到 mysql 创建数据库，能够根据 model.txt 自动创建
Do you want to migrate database? [Y|N]

```

## 生成好了后
1. 到生成的 model 文件

```php
# 修改数据库配置
protected $connection = '';
protected $table = '';

# 如果表不是 laravel 自动维护 create_up,update_at 字段的话，改为
public $timestamps =  false;
# 同时，没有时间字段的话，修改 view.YOUR_MODEL.index.blade.php
@include('public.component.search')
#为
@include('public.component.search', ['disableDate' => true])

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

## 在项目根目录创建 `model.txt`

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

# 出现问题

`model.txt` 很可能有写错的地方，生成完后发现有问题的话就改吧改吧再生成一次

## 最后

打开 `app\Http\Composers\SidebarComposer.php`

然后 把确认无误的 `model.txt` 备份一份到 `database\define` 吧！

# Todos

- 读取数据库，自动生成 model.txt
- 支持应用分组
- view 模板
- 表单字段类型

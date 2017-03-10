<?php
include 'autoload.php';

use  Valitron\Validator;

  $postData = array(
                  'product_id' => 10009,
                  'product_type' => 5,
                  'link_number' => 2,
                  'task_link' => 'http://e.inner.evente.cn:30280/900764',
                  'task_name' => 'www'
                );

             $Validator = new Validator($postData);
             $field = ['task_name','task_link','link_number','product_type','product_id'];

            //这里是添加的自定义验证，可以用此方法加多个，也可改类的源文件
             $Validator->addRule('validatespecial',function($field,$value){
                 if(in_array(substr($value,-1),array('?','&'))){
                      return false;
                 }
                 return true;
              },"有特殊的字符");

           $Validator->rule("required",$field);  //不能为空
           $Validator->rule("min",['link_number'],1);  //link_number字段最小为1
           $Validator->rule("max",['link_number'],50); //link_number字段最大为50
           $Validator->rule("validatespecial",['task_link']); //使用自定义的验证，只为判断最后一位不能为?和&符号
            //这里是将字段对应成汉字，返回错误消息时 返回对应的汉字
           $Validator->labels([
               'taskname' => '任务名称',
               'task_link' => '链接地址',
               'link_number' => '添加数量'
           ]);

           if ($Validator->validate()){
                echo '验证成功';
               extract($postData); //按数组生成单独变量
           }else{
               echo '<pre>';
               print_r($Validator->errors());
           }



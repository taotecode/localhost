<?php
/**
 * ${NAME}
 * @project localhost
 * @copyright 院主网络科技
 * @author yuanzhumc
 * @version 1.0
 * @date: 2021/6/9
 * @createTime 17:13
 * @filename common.php
 * @product_name PhpStorm
 * @link https://github.com/yuanzhumc/localhost
 * @example
 */


use lib\Env;
Env::loadFile();


/**
 * 获取nginx的*.conf文件内容
 * @param string $name 文件名称:localhost.conf
 * @return false|string
 */
function openNginxConf($name){
    return file_get_contents(Env::get('localhost.nginxconf','/usr/local/nginx/conf/vhost/').$name)?:'null';
}

/**
 * 获取网站的.env文件
 * @param string $name 网站目录名称:localhost
 * @return false|string
 */
function openWebEnv($name){
    return file_get_contents(Env::get('localhost.wwwroot','/data/wwwroot/').$name.'/'.Env::get('localhost.wwwrootenv','.env'))?:'null';
}

/**
 * json写入操作
 * @param array $data
 * @param string $file
 */
function fileArray($data,$file){
    $file_pointer = fopen("app/data/".$file.".json", 'w+');
    fwrite($file_pointer,json_encode($data));
    fclose($file_pointer);
}

function ProjectParamFile(){
    $Array = [
        'common' => [
            [
                'title' => '项目名称',
                'name' => 'title',
                'type' => 'text',
                "required" => true,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "本地域名",
                "name" => "localhost",
                "type" => "text",
                "required" => true,
                "href" => true,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "账号",
                "name" => "localUser",
                "type" => "text",
                "required" => true,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "密码",
                "name" => "localPass",
                "type" => "text",
                "required" => true,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "线上域名",
                "name" => "domain",
                "type" => "text",
                "required" => false,
                "href" => true,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "账号",
                "name" => "domainUser",
                "type" => "text",
                "required" => false,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "密码",
                "name" => "domainPass",
                "type" => "text",
                "required" => false,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "Git地址",
                "name" => "git",
                "type" => "text",
                "required" => false,
                "href" => true,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "Git分支",
                "name" => "gitBranch",
                "type" => "text",
                "required" => false,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "nginx文件",
                "name" => "nginx",
                "type" => "nginx",
                "required" => false,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "网站目录",
                "name" => "env",
                "type" => "env",
                "required" => false,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ],
            [
                "title" => "开发备注",
                "name" => "remarks",
                "type" => "remarks",
                "required" => false,
                "href" => false,
                "hrefStart" => "http://",
                "hrefEnd" => "/"
            ]
        ]
    ];
    if (empty(Env::get('project.json'))){
        if (!fileCheck('app/data/ProjectParam.json')){
            fileArray($Array,'ProjectParam');
        }
    }else{
        if (!fileCheck('app/data/ProjectParam.json')){
            fileArray($Array,'ProjectParam');
        }
    }
}

function fileCheck($filename){
    if (file_exists($filename)) {
        return true;
    }
    return false;
}

/**
 * 页面展示
 * @param string $index 应用名称
 * @param array $data 其他数据
 * @return string
 */
function viewShow($index="app/index",$data=[]){
    return 'template/view/'.$index.'.php';
}

/**
 * 链接生成
 * @param string $title 链接名称
 * @param string $index 应用名称
 * @param string $target 链接打开方式
 * @return string
 */
function munuHref($title, string $index="app/index", $target='_self'){
    return '<a href="index.php?app='.$index.'" target="'.$target.'">'.$title.'</a>';
}
/**
 * 菜单生成
 * @param string $index 应用名称
 * @return string|null
 */
function munu($index="app/index"){
    $munuJosn=file_get_contents('app/data/munu.json');
    if (!$munuJosn||empty($munuJosn)){
        $munuArray=[
            ['title'=>'本地环境信息','type'=>'in','url'=>'app/index','target'=>'_self'],
            ['title'=>'根目录','type'=>'in','url'=>'app/file','target'=>'_self'],
            ['title'=>'项目','type'=>'in_child','url'=>null,'target'=>'javascript:;','child'=>'project'],
            ['title'=>'公司','type'=>'in_child_in','url'=>'app/project&mode=company','target'=>'_self','child'=>'project'],
            ['title'=>'我的','type'=>'in_child_in','url'=>'app/project&mode=my','target'=>'_self','child'=>'project'],
            ['title'=>'在线文档','type'=>'in','url'=>'app/word','target'=>'_self'],
        ];
        fileArray($munuArray,'munu');
        $munuJosn=json_encode($munuArray);
    }
    $munuJosn=json_decode($munuJosn,true);
    $html=null;
    foreach ($munuJosn as $k=>$v){
        if ($v['type']=='in'){
            if ($v['url']==$index){
                $html .= '<li class="layui-nav-item layui-nav-itemed">'.munuHref($v['title'],$v['url'],$v['target']).'</li>';
            }else{
                $html .= '<li class="layui-nav-item">'.munuHref($v['title'],$v['url'],$v['target']).'</li>';
            }
        }elseif ($v['type']=='in_child'){
            if ($v['url']==$index){
                $html .= '<li class="layui-nav-item layui-nav-itemed"><a href="javascript:;">'.$v['title'].'</a>';
                $html.='<dl class="layui-nav-child">';
                $child=$v['child'];
                foreach ($munuJosn as $value){
                    if ($value['type']=='in_child_in'&&$value['child']==$child){
                        $html .='<dd>'.munuHref($value['title'],$value['url'],$value['target']).'</dd>';
                    }
                }
                $html .='</dl></li>';
            }else{
                $html .= '<li class="layui-nav-item"><a href="javascript:;">'.$v['title'].'</a>';
                $html.='<dl class="layui-nav-child">';
                $child=$v['child'];
                foreach ($munuJosn as $value){
                    if ($value['type']=='in_child_in'&&$value['child']==$child){
                        $html .='<dd>'.munuHref($value['title'],$value['url'],$value['target']).'</dd>';
                    }
                }
                $html .='</dl></li>';
            }
        }
    }
    return $html;
}
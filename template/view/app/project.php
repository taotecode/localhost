<?php
/**
 * ${NAME}
 * @project aix
 * @copyright
 * @author chenjw
 * @version
 * @date: 2021/6/10
 * @createTime 13:20
 * @filename aix.php
 * @product_name PhpStorm
 * @link
 * @example
 */


use lib\Env;
Env::loadFile();


$getData=$_GET;
$getMode=$getData['mode']?:'my';
$data=file_get_contents('app/data/'.$getMode.'.json');
$data=json_decode($data,true);

$paramData=file_get_contents(Env::get('project.json'));
$paramData=json_decode($paramData,true);

if (empty($paramData[$getMode])){
    $paramData=$paramData['common'];
}else{
    $paramData=$paramData[$getMode];
}

if (isset($_POST['type'])||!empty($_POST['type'])){
    $postData=$_POST;
    switch ($_POST['type']){
        case 'add':
            $jsonData=null;
            foreach ($paramData as $datum){
                $jsonData[$datum['name']] =$postData[$datum['name']];
            }
            $data[]=$jsonData;
            fileArray($data,$getMode);
            $returnData=['status'=>200,'msg'=>'添加成功'];
            break;
        case 'edit':
            $jsonData=null;
            foreach ($paramData as $datum){
                $jsonData[$datum['name']] =$postData[$datum['name']];
            }
            $data[$postData['key']?:'0']=$jsonData;
            fileArray($data,$getMode);
            $returnData=['status'=>200,'msg'=>'编辑成功'];
            break;
        case 'del':
            unset($data[$postData['key']?:'0']);
            fileArray($data,'aix');
            $returnData=['status'=>200,'msg'=>'删除成功'];
            break;
    }
    header("content-type:application/json");
    exit(json_encode($returnData));
}
?>
<fieldset class="layui-elem-field" id="operation">
    <legend>操作区</legend>
    <div class="layui-field-box">
        <div class="layui-btn-container">
            <button type="button" class="layui-btn layui-btn-primary layui-border-blue layui-btn-sm" onclick="add()">增加</button>
        </div>
    </div>
</fieldset>
<div id="catalogue" style="display: none;height: 600px">
    <ul class="site-dir">
        <li><a href="#operation"><cite>操作</cite></a></li>
        <?php
        foreach ($data as $k=>$v){
            echo '<li><a href="#'.$k.'"><cite>'.$v['title'].'</cite></a></li>';
        }
        ?>
    </ul>
</div>
<fieldset class="layui-elem-field layui-field-title">
    <legend>网站项目</legend>
    <div class="layui-field-box" style="background-color:#F2F2F2;padding: 20px">
        <?php
        $showHtml='';
        foreach ($data as $k=>$v){
            $editData="'".$k."',";
            foreach ($paramData as $key=>$item){
                if (count($paramData)-1==$key){
                    $editData.="'".$v[$item['name']]."'";
                }else{
                    $editData.="'".$v[$item['name']]."',";
                }
            }
            $showHtml .= '
<div class="layui-card" id="'.$k.'">
            <div class="layui-card-header">'.$v['title'].'</div>
            <div class="layui-card-body">
            ';
                foreach ($paramData as $key=>$item){
                    if ($item['href']){
                        $showHtml .= '<p><b>'.$item['title'].'：</b><a href="'.$item['hrefStart'].$v['localhost'].$item['hrefEnd'].'" target="_blank">'.$v[$item['name']].'</a></p>';
                    }else{
                        if ($item['type']=='nginx'||$item['type']=='env'||$item['type']=='remarks'){}else{
                            $showHtml .= '<p><b>' . $item['title'] . '：</b>' . $v[$item['name']] . '</p>';
                        }
                    }
                }
                $showHtml .='<hr>
                <div class="layui-collapse" lay-accordion>';
            foreach ($paramData as $key=>$item){
                if($item['type']=='nginx'){
                    if (Env::get('project.nginx')) {
                        $showHtml .= '
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">' . $item['title'] . '</h2>
                        <div class="layui-colla-content">
<pre class="layui-code" lay-title="' . $item['title'] . '" lay-lang="nginx.conf" lay-encode="true">
' . openNginxConf($v[$item['name']]) . '
</pre>
                        </div>
                    </div>
                    ';
                    }
                }elseif ($item['type']=='env'){
                    if (Env::get('project.env')) {
                        $showHtml .= '
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">' . $item['title'] . '</h2>
                        <div class="layui-colla-content">
<pre class="layui-code" lay-title="' . $item['title'] . '" lay-lang=".env" lay-encode="true">
' . openWebEnv($v[$item['name']]) . '
</pre>
                        </div>
                    </div>
                    ';
                    }
                }elseif ($item['type']=='remarks'){
                    if (Env::get('project.remarks')) {
                        $showHtml .= '
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">' . $item['title'] . '</h2>
                        <div class="layui-colla-content">
'.$v[$item['name']].'
                        </div>
                    </div>
                    ';
                    }
                }
            }
            $showHtml .='</div>
                <hr>
                <div class="layui-btn-container">
                    <button type="button" class="layui-btn layui-btn-primary layui-border-blue layui-btn-sm" onclick="edit('.$editData.')">编辑</button>
                    <button type="button" class="layui-btn layui-btn-primary layui-border-blue layui-btn-sm" onclick="del('."'".$k."'".')">删除</button>
                </div>
            </div>
        </div>
';
        }
        echo $showHtml;
        ?>
    </div>
</fieldset>
<div id="form" style="display:none;padding: 20px">
    <form class="layui-form" action="" lay-filter="form">
        <?php
        $form_html='';
        foreach ($paramData as $k=>$v){
            if ($v['type']=='text'){
                $form_html .= '
        <div class="layui-form-item">
            <label class="layui-form-label">'.$v['title'].'</label>
            <div class="layui-input-block">
                <input type="text" name="'.$v['name'].'" ';
                if ($v['required']) $form_html.= 'required  lay-verify="required"';
                $form_html .=' autocomplete="off" class="layui-input">
            </div>
        </div>
                ';
            }elseif ($v['type']=='nginx'){
                if (Env::get('project.nginx')){
                    $form_html .= '
        <div class="layui-form-item">
            <label class="layui-form-label">'.$v['title'].'</label>
            <div class="layui-input-block">
                <input type="text" name="'.$v['name'].'" ';
                    if ($v['required']) $form_html.= 'required  lay-verify="required"';
                    $form_html .=' autocomplete="off" class="layui-input">
            </div>
        </div>
                ';
                }
            }elseif ($v['type']=='env'){
                if (Env::get('project.env')){
                    $form_html .= '
        <div class="layui-form-item">
            <label class="layui-form-label">'.$v['title'].'</label>
            <div class="layui-input-block">
                <input type="text" name="'.$v['name'].'" ';
                    if ($v['required']) $form_html.= 'required  lay-verify="required"';
                    $form_html .=' autocomplete="off" class="layui-input">
            </div>
        </div>
                ';
                }
            }elseif ($v['type']=='remarks'){
                if (Env::get('project.remarks')){
                    $form_html .= '
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">'.$v['title'].'</label>
            <div class="layui-input-block">
                <textarea name="'.$v['name'].'" class="layui-textarea"></textarea>
            </div>
        </div>
                ';
                }
            }
        }
        echo $form_html;
        ?>
        <input type="hidden" name="type" value="add">
        <input type="hidden" name="key" value="">
        <hr>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-primary layui-border-blue" lay-submit lay-filter="form">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['code', 'form'], function(){
        var form = layui.form;
        layui.code();
        form.on('submit(form)', function(data){
            $.ajax({
                type: "POST",
                url: "index.php?app=app/project&mode=<?php echo $getMode?>",
                data: {
                    type:data.field.type,
                    key:data.field.key,
                    <?php
                    $ajaxModeData='';
                    foreach ($paramData as $v){
                        $ajaxModeData .=$v['name'].' : data.field.'.$v['name'].',';
                    }
                    echo $ajaxModeData;
                    ?>
                },
                datatype: "json",
                success: function (result) {
                    if (result.status=='200'){
                        layer.msg(result.msg, function(){
                            location.reload();
                        });
                    }else{
                        layer.msg(result.msg, {icon: 2});
                    }
                }
            });
            return false;
        });
    });
    layer.open({
        type: 1,title:"目录",shade:0,closeBtn:0,offset: 'r',skin: 'layui-layer-dir',
        content: $('#catalogue')
    });
    function add() {
        layer.open({
            type: 1,title:"新增",shade:0,area: ['450px', '750px']
            ,content: $('#form')
        });
    }
    function edit(
        key,
        <?php
        $editParam='';
        foreach ($paramData as $v){
            $editParam .=$v['name'].',';
        }
        echo $editParam;
        ?>
    ) {
        layer.open({
            type: 1,title:"编辑",shade:0,area: ['450px', '750px']
            ,content: $('#form')
            ,success:function (layero, index) {
                layui.use('form', function() {
                    var form = layui.form;
                    form.val("form", {
                        "type": "edit",
                        "key":key,
                        <?php
                        $editFormParam='';
                        foreach ($paramData as $v){
                            $editFormParam .="'".$v['name']."':".$v['name'].',';
                        }
                        echo $editFormParam;
                        ?>
                    });
                });
            }
        });
    }
    function del(key) {
        $.ajax({
            type: "POST",
            url: "index.php?app=app/project&mode=<?php echo $getMode?>",
            data: {
                type:'del',key:key
            },
            datatype: "json",
            success: function (result) {
                if (result.status=='200'){
                    layer.msg(result.msg, function(){
                        location.reload();
                    });
                }else{
                    layer.msg(result.msg, {icon: 2});
                }
            }
        });
    }
</script>
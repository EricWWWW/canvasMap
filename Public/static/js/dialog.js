var dialog = function(data){
    switch (data.status){
        case 0:
            layer.open({
                type:0,
                content:data.msg,
                icon:2,
                btn:false,
                title : '操作失败',
            });

            break;
        case 1:
            layer.open({
                type:0,
                content:data.msg,
                icon:1,
                btn:false,
                time:1500,
                title : '操作成功',
            });

            break;
        default:
            layer.open({
                type:0,
                content:data.msg,
                icon:0,
                btn:false,
                title : '提示',
            });

            break;
    }
}
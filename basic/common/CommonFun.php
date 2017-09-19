<?php
namespace common;


class CommonFun{


    /**
     * 统一采用json格式数据返回
     * @param int $status 状态，不能为空
     * @param array  $data   数据，可以为空
     * @param string $msg    错误描述，可以为空
     */
    public static function JsonResponse($status,$msg='',$data=[])
    {
        if(is_int($status) && is_array($data))
        {
            $res = [
                "status" => $status,
                "msg" => $msg,
                "data" => $data,
            ];
            echo json_encode($res);
        }
        else
        {
            throw new \Exception("数据格式不正确：status必须整数，msg必须是字符串，data必须是数组");
        }

    }
    /**
     * 调用成功返回
     * @param array $data 数据
     */
    public static function JsonSuccess($msg='成功',$data=[])
    {
        CommonFun::JsonResponse(200,$msg,$data);
    }

    /**
     * 失败返回
     * @param array $data 数据
     */
    public static function JsonFail($msg='失败',$data=[])
    {
        CommonFun::JsonResponse(404,$msg,$data);
    }


    /**
     * 生成32位guid唯一标识
     * 所有id都用这个生成
     * @return string
     */
    public static function CreateId() {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);
        $uuid =
            substr($charid, 0, 8)
            .substr($charid, 8, 4)
            .substr($charid,12, 4)
            .substr($charid,16, 4)
            .substr($charid,20,12)
        ;
        return $uuid;
    }

    /**
     * 获取客户端IP
     * @return string 返回ip地址,如127.0.0.1
     */
    public static function GetClientIp()
    {
        $onlineip = 'Unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ips = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            $real_ip = $ips['0'];
            if ($_SERVER['HTTP_X_FORWARDED_FOR'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $real_ip))
            {
                $onlineip = $real_ip;
            }
            elseif ($_SERVER['HTTP_CLIENT_IP'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']))
            {
                $onlineip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['HTTP_CDN_SRC_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CDN_SRC_IP']))
        {
            $onlineip = $_SERVER['HTTP_CDN_SRC_IP'];
            $c_agentip = 0;
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['HTTP_NS_IP']) && preg_match ( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_NS_IP'] ))
        {
            $onlineip = $_SERVER ['HTTP_NS_IP'];
            $c_agentip = 0;
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['REMOTE_ADDR']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['REMOTE_ADDR']))
        {
            $onlineip = $_SERVER['REMOTE_ADDR'];
            $c_agentip = 0;
        }
        return $onlineip;
    }
    /**
     * 保存上传的文件
     * @param string $name 提交的字段名 例如：<input name='name'>
     * return string 保存的相对位置，可直接保存在数据库
     */
    public static function SaveFile($name)
    {
        if(isset($_FILES[$name]))
        {
            $type = explode("/",$_FILES[$name]['type']);
            $visiteUrl = '/upload';
            $url = $_SERVER['DOCUMENT_ROOT'].$visiteUrl;
            if (!file_exists($url))
                mkdir($url);
            $id = CommonFun::CreateId();
            $visiteUrl .=  '/'.$id.'.'.$type[1];
            $url .= '/'.$id.'.'.$type[1];
            move_uploaded_file($_FILES[$name]["tmp_name"], $url);
            return $visiteUrl;
        }
    }
}

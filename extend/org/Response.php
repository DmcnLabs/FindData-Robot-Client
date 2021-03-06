<?php
namespace org;
/**
 * 生成API接口数据格式（支持json、xml格式）
 */
class Response{
    function gen($data = array(),$type='json', $charset='utf-8'){
        ob_clean();
        @header("Expires: -1");
        @header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
        @header("Pragma: no-cache");
        if($type == 'xml'){
            return self::xml($data,$charset);
        }else{
            return self::json($data,$charset);
        }
    }

    function json($data = array(), $charset){
        header('Content-Type: application/json; charset='.$charset.'');
//        $data = self::jsonToEncode($data);
//        $json = urldecode(json_encode($data));
        $json = json_encode($data); //以上的采用url编解码方式，内容数据过多时不能正常识别未解决。先直接使用。
        echo $json;
        exit;
    }
    function jsonToEncode($data){
        foreach ($data as $key => $value) {
            $data[$key] = is_array($value) ? self::jsonToEncode($value) : urlencode($value);
        }
        return $data;
    }

    function xml($data = array(), $charset){
        header("Content-type: application/xml");
        $xml = "<?xml version='1.0' encoding='".$charset."'?>\n";
        $xml .= "<finndy>\n";
        $xml .= self::xmlToEncode($data);
        $xml .= "</finndy>";
        $xml .= "<!-- Generated by FindData Service -->";
        echo $xml;
        exit;
    }
    function xmlToEncode($data){
        $xml = '';
        foreach($data as $key => $value){
            if(is_numeric($key)){
                $key = "item";
            }
            $xml .= "<{$key}>";
            $xml .= is_array($value) ?  self::xmlToEncode($value) : (is_numeric($value)?"{$value}":"<![CDATA[{$value}]]>");
            $xml .= "</{$key}>\n";
        }
        return $xml;
    }
}
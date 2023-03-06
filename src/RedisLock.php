<?php
namespace v10086;
class RedisLock{
    
    public static $redisHandler=null; //redis操作句柄 默认为空
    public static $maxPttl=60000;//锁的默认最大有效时间 默认60秒


    //上锁
    //$key 锁的键名
    //$pttl 锁的有效时间  粒度为毫秒
    public static function lock($key,$ttl=null) {
        if(self::$redisHandler==null){
            throw new \Exception("请先初始化可用的redis操作句柄");
        }
        return self::$redisHandler->SET('redLock:'.$key,1, ['NX', 'PX' => $ttl]);
    }
    
    //解锁
    public static function unlock($key){
        return self::$redisHandler->DEL('redLock:'.$key);
    }
}

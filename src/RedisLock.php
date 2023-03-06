<?php
namespace v10086;
class RedisLock{
    public static $redisHandler=null; //redis操作句柄 默认为空
    //上锁
    //$key 锁的键名
    //$ttl 锁的有效时间  粒度为毫秒 默认60秒
    public static function lock($key,$ttl=60000) {
        if(self::$redisHandler==null){
            throw new \Exception("请先初始化可用的redis操作句柄");
        }
        return self::$redisHandler->SET('redLock:'.$key,1, ['NX', 'PX' => $ttl]);
    }
    
    //解锁
    public static function unlock($key){
        return self::$redisHandler->DEL('redLock:'.$key);
        
        //执行lua脚本 
        return self::$redisHandler->EVAL('
            if redis.call("GET", KEYS[1]) == ARGV[1] then
                return redis.call("DEL", KEYS[1])
            else
                return 0
            end
        ', ['redLock:'.$key, 1], 1);
        
    }
}

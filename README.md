📃 开源协议 Apache License Version 2.0 see http://www.apache.org/licenses/LICENSE-2.0.html
# 简介

Redis分布式锁(Distributed locks) 用Redis实现一个分布式锁管理。


版本说明
--------------------------------------------------------------------------

PHP7.0+版本 必须安装phpredis拓展

安装教程
--------------------------------------------------------------------------

composer require v10086/redis-lock:v1.0

使用示例
--------------------------------------------------------------------------


```php


namespace v10086;
class RedisLock{
    
    public static $redisHandler=null; //redis操作句柄 默认为空
    public static $maxPttl=60000;//锁的最大生成时间 默认60秒


    //上锁
    //$key 锁的键名
    //$pttl 锁的有效时间  粒度为毫秒
    public static function lock($key,$pttl=null) {
        if(self::$redisHandler==null){
            throw new \Exception("请先初始化可用的redis操作句柄");
        }
        $res=self::$redisHandler->HSETNX('redLock:'.$key,$key,1);
        if($res!='1'){
            return false;
        }
        if($pttl!==null){
           self::$redisHandler->PEXPIRE('redLock:'.$key,$pttl);
        }else{
            self::$redisHandler->PEXPIRE('redLock:'.$key, self::$maxPttl);
        }
        return true;
    }
    
    //解锁
    public static function unlock($key){
        return self::$redisHandler->DEL('redLock:'.$key);
    }
}




```
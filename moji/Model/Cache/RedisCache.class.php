<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2014/12/26
 * Time: 14:01
 */

class RedisCache {

    public $client = null;

    private $host = null;
    private $port = null;
    private $persistent = false;
    private $timeout = 30;

    public function __construct($config = null){
        $this->loadExt();
        if(!empty($config)){
            $this->set($config);
        }
    }

    /**连接redis
     * @return null|Redis
     * @throws Exception
     */
    public function connect(){
        if($this->client !== null){
            return $this->client;
        }
        if(null == $this->host){
            throw new Exception('no config for redis');
        }
        $this->client = new Redis();
        if($this->persistent){
            $this->client->pconnect($this->host,$this->port,$this->timeout);
        }else{
            $this->client->connect($this->host,$this->port,$this->timeout);
        }
        return $this->client;
    }

    /**设置连接参数
     * @param $config
     */
    public function set($config)
    {
        if (is_array($config)) {
            $this->host = $config['host'];
            $this->port = $config['port'];
            if (isset($config['timeout'])) {
                $this->setTimeout($config['timeout']);
            }
            if (isset($config['persist'])) {
                $this->persistent = $config['persist'];
            }
        } elseif (is_string($config)) {
            $strs = explode(':', $config);
            $this->host = $strs [0];
            $this->port = $strs [1];
            if (isset($strs[2])) {
                $this->setTimeout($strs[2]);
            }
        } else {
            throw new InvalidArgumentException("unknown config for socketConfig:" . $config);
        }
    }

    /**设置超时时间
     * @param $val
     */
    private function setTimeout($val){
        $this->timeout = floatval($val);
        if($this->timeout < 0){
            $this->timeout = 30;
        }
    }

    /**设置字符串
     * @param $key
     * @param $value
     * @param int $expire
     * @return bool
     * @throws Exception
     */
    public function stringSet($key,$value,$expire = 0){
        if($expire > 0 ){
            return $this->connect()->setex($key, $expire, $value);
        }
        return $this->connect()->set($key, $value);
    }

    /**取字符串值
     * @param $key
     * @return bool|string
     * @throws Exception
     */
    public function stringGet($key){
        return $this->connect()->get($key);
    }

    /**删除字符串key
     * @param $key
     * @return int|void
     * @throws Exception
     */
    public function stringDel($key){
        if(is_array($key)){
            return $this->connect()->del($key);
        }
        return $this->connect()->delete($key);
    }

    /**设置hash值
     * @param $redisKey
     * @param $key
     * @param $val
     * @return int
     * @throws Exception
     */
    public function hashSet($redisKey,$key,$val){
        return $this->connect()->hSet($redisKey,$key,$val);
    }

    /**批量设置hash值
     * @param $redisKey
     * @param $keysVals
     * @return array
     * @throws Exception
     */
    public function hashMSet($redisKey,$keysVals){
        return $this->connect()->hMGet($redisKey,$keysVals);
    }
    /**取hash值
     * @param $redisKey
     * @param $key
     * @return string
     * @throws Exception
     */
    public function hashGet($redisKey,$key){
        if(is_array($key)){
            return $this->connect()->hMGet($redisKey,$key);
        }
        return $this->connect()->hGet($redisKey,$key);
    }

    /**查询是否存在值
     * @param $redisKey
     * @param $key
     * @return bool
     * @throws Exception
     */
    public function hashExists($redisKey,$key){
        return $this->connect()->hExists($redisKey,$key);
    }


    /**排行榜增加积分
     * @param $redisKey
     * @param $key
     * @param $score
     * @return int
     * @throws Exception
     */
    public function sortedsetsIncrby($redisKey,$key,$score){
        return $this->connect()->zAdd($redisKey,$score,$key);
    }

    /**取得有多少个元素
     * @param $redisKey
     * @return int
     * @throws Exception
     */
    public function sortedsetsCard($redisKey){
        return $this->connect()->zCard($redisKey);
    }

    /**取分数之间有多少个元素
     * @param $redisKey
     * @param $start
     * @param $end
     * @return int
     * @throws Exception
     */
    public function sortedsetsCount($redisKey,$startScore,$endScore){
        return $this->connect()->zCount($redisKey,$startScore,$endScore);
    }

    /**按名次取排行榜
     * @param $redisKey
     * @param $start
     * @param $end
     * @param bool $withscores
     * @param bool $desc
     * @return array
     * @throws Exception
     */
    public function sortedsetsRange($redisKey,$start,$end,$withscores = true,$desc = true){
        if($desc){
            return $this->connect()->zRevRange($redisKey,$start,$end,$withscores);
        }else{
            return $this->connect()->zRange($redisKey,$start,$end,$withscores);
        }
    }


    /**按分数取排行榜
     * @param $redisKey
     * @param $start
     * @param $end
     * @param bool $desc
     * @return array
     * @throws Exception
     */
    public function sortedsetsRangeByScore($redisKey,$start,$end,$desc = true){
        if($desc){
            return $this->connect()->zRevRangeByScore($redisKey,$start,$end);
        }else{
            return $this->connect()->zRangeByScore($redisKey,$start,$end);
        }
    }

    /**取得名次
     * @param $redisKey
     * @param $key
     * @param bool $desc
     * @return int
     * @throws Exception
     */
    public function sortedsetsRank($redisKey,$key,$desc = true){
        if($desc){
            $rank = $this->connect()->zRevRank($redisKey,$key);
        }else{
            $rank = $this->connect()->zRank($redisKey,$key);
        }
        if($rank === false){
            $rank = 0;
        }else{
            $rank += 1;
        }
        return $rank;
    }
    /**加载扩展
     * @throws Exception
     */
    private function loadExt(){
        if(!extension_loaded('Redis')){
            throw new Exception('no extension Redis');
        }
    }
}
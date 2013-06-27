<?php
/**
 * platform-admin Search.php
 * @DateTime 13-5-28 下午4:35
 */

namespace Platform\Ip;

/**
 * Class Search
 * @package Platform\Ip
 * @author Xiemaomao
 * @version $Id$
 */
class IpLocation
{
    protected static $instance;

    /**
     * Singleton instance
     *
     * @return static
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            $class = new \ReflectionClass(__CLASS__);
            self::$instance = $class->newInstanceArgs(func_get_args());
        }

        return self::$instance;
    }

    protected $charset = 'utf-8';

    protected $source;

    protected $fileHandle;

    protected static $province = [
        '北京市', '天津市', '河北省', '山西省', '内蒙古', '辽宁省',
        '吉林省', '黑龙江省', '上海市', '江苏省', '浙江省', '安徽省', '福建省', '江西省', '山东省',
        '河南省', '湖北省', '湖南省', '广东省', '广西', '海南省', '重庆市', '四川省',
        '贵州省', '云南省', '西藏自治区', '陕西省', '甘肃省', '青海省', '宁夏',
        '新疆', '台湾省', '香港', '澳门'
    ];

    /**
     * 设置IP数据文件
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    protected function getFileHandle()
    {
        if(!$this->fileHandle) {
            $this->source = $this->source ? : (dirname(__FILE__) . '/qqwry.dat');
            $this->fileHandle = fopen(realpath($this->source), 'rb');

            if (!$this->fileHandle) {
                throw new \RuntimeException('未知IP库文件');
            }
        }

        return $this->fileHandle;
    }

    /**
     * @param $ip
     *
     * @return array|string  array('省', '省市'，'信息');
     * @throws \RuntimeException
     */
    public static function search($ip)
    {
        if (!ip2long($ip)) {
            throw new \RuntimeException('Error IP address.');
        }
        $self = self::getInstance();
        $fd = $self->getFileHandle();

        $ip = explode('.', $ip);
        $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

        if(!($DataBegin = fread($fd, 4)) || !($DataEnd = fread($fd, 4)) ) return;
        @$ipbegin = implode('', unpack('L', $DataBegin));
        if($ipbegin < 0) $ipbegin += pow(2, 32);
        @$ipend = implode('', unpack('L', $DataEnd));
        if($ipend < 0) $ipend += pow(2, 32);
        $ipAllNum = ($ipend - $ipbegin) / 7 + 1;

        $BeginNum = $ip2num = $ip1num = 0;
        $ipAddr1 = $ipAddr2 = '';
        $EndNum = $ipAllNum;

        while($ip1num > $ipNum || $ip2num < $ipNum) {
            $Middle= intval(($EndNum + $BeginNum) / 2);

            fseek($fd, $ipbegin + 7 * $Middle);
            $ipData1 = fread($fd, 4);
            if(strlen($ipData1) < 4) {
                fclose($fd);
                return '- System Error';
            }
            $ip1num = implode('', unpack('L', $ipData1));
            if($ip1num < 0) $ip1num += pow(2, 32);

            if($ip1num > $ipNum) {
                $EndNum = $Middle;
                continue;
            }

            $DataSeek = fread($fd, 3);
            if(strlen($DataSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
            fseek($fd, $DataSeek);
            $ipData2 = fread($fd, 4);
            if(strlen($ipData2) < 4) {
                fclose($fd);
                return '- System Error';
            }
            $ip2num = implode('', unpack('L', $ipData2));
            if($ip2num < 0) $ip2num += pow(2, 32);

            if($ip2num < $ipNum) {
                if($Middle == $BeginNum) {
                    fclose($fd);
                    return '- Unknown';
                }
                $BeginNum = $Middle;
            }
        }

        $ipFlag = fread($fd, 1);
        if($ipFlag == chr(1)) {
            $ipSeek = fread($fd, 3);
            if(strlen($ipSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
            fseek($fd, $ipSeek);
            $ipFlag = fread($fd, 1);
        }

        if($ipFlag == chr(2)) {
            $AddrSeek = fread($fd, 3);
            if(strlen($AddrSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $ipFlag = fread($fd, 1);
            if($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if(strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return '- System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, -1, SEEK_CUR);
            }

            while(($char = fread($fd, 1)) != chr(0))
                $ipAddr2 .= $char;

            $AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
            fseek($fd, $AddrSeek);

            while(($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;
        } else {
            fseek($fd, -1, SEEK_CUR);
            while(($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;

            $ipFlag = fread($fd, 1);
            if($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if(strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return '- System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, -1, SEEK_CUR);
            }
            while(($char = fread($fd, 1)) != chr(0))
                $ipAddr2 .= $char;
        }

        if(strpos($ipAddr2, 'http') !== false) {
            $ipAddr2 = '';
        }
        if(strpos($ipAddr1, 'http') !== false) {
            $ipAddr1 = 'Unknown';
        }

        $ipAddr1 = trim($ipAddr1);
        $ipAddr2 = trim(str_ireplace('cz88.net', '', $ipAddr2));

        if ($self->charset != 'gb2312') {
            $ipAddr1 = iconv('gb2312', $self->charset, $ipAddr1);
            $ipAddr2 = iconv('gb2312', $self->charset, $ipAddr2);
        }

        $province = 'Unknown';
        if (preg_match('/^(' . implode('|', self::$province) . ')/', $ipAddr1, $m)) {
            $province = $m[0];
        }

        return array($province, $ipAddr1, $ipAddr2);
    }

    public function __destruct()
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
    }

    /**
     * @param string $charset
     *
     * @return IpLocation
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }


}
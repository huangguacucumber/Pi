<?php
    set_time_limit(0);
    class pi
    {
        public static function calc($__N__)
        {
            $n = (int)$__N__;
            $av = $a = $vmax = $N = $num = $den = $k = $kq = $kq2 = $t = $v = $s = $i = 0;
            $sum = 0.0;
            $N = (int)(($n + 20) * log(10) / log(2));
            $sum = 0;
            for ($a = 3; $a <= (2 * $N); $a = self::next_prime($a))
            {
                $vmax = (int)(log(2 * $N) / log($a));
                $av = 1;
                for ($i = 0; $i < $vmax; $i ++)
                {
                    $av = ($av * $a);
                }
                $s = 0;
                $num = 1;
                $den = 1;
                $v = 0;
                $kq = 1;
                $kq2 = 1;
                for ($k = 1; $k <= $N; $k ++)
                {
                    $t = $k;
                    if ($kq >= $a)
                    {
                        do
                        {
                            $t = (int)($t / $a);
                            $v --;
                        }
                        while (($t % $a) == 0);
                        $kq = 0;
                    }
                    $kq ++;
                    $num = self::mul_mod($num, $t, $av);
                    $t = (2 * $k -1);
                    if ($kq2 >= $a)
                    {
                        if ($kq2 == $a)
                        {
                            do
                            {
                                $t = (int)($t / $a);
                                $v ++;
                            }
                            while (($t % $a) == 0);
                        }
                        $kq2 -= $a;
                    }
                    $den = self::mul_mod($den, $t, $av);
                    $kq2 += 2;
                    if ($v > 0)
                    {
                        $t = self::inv_mod($den, $av);
                        $t = self::mul_mod($t, $num, $av);
                        $t = self::mul_mod($t, $k, $av);
                        for ($i = $v; $i < $vmax; $i ++)
                        {
                            $t = self::mul_mod($t, $a, $av);
                        }
                        $s += $t;
                        if ($s >= $av)
                        {
                            $s -= $av;
                        }
                    }
                }
                $t = self::pow_mod(10, ($n - 1), $av);
                $s = self::mul_mod($s, $t, $av);
                $sum = (double)fmod((double)$sum + (double)$s / (double)$av, 1.0);
            }
            return array(
                'n' => $n,
                'v' => sprintf('%09d', (int)($sum * 1e9))
            );
        }
        private static function next_prime($n)
        {
            do
            {
                $n ++;
            }
            while (!self::is_prime($n));
            return $n;
        }
        private static function is_prime($n)
        {
            $r = $i = 0;
            if (($n % 2) == 0)
            {
                return 0;
            }
            $r = (int)(sqrt($n));
            for ($i = 3; $i <= $r; $i += 2)
            {
                if (($n % $i) == 0)
                {
                    return 0;
                }
            }
            return 1;
        }
        private static function mul_mod($a, $b, $m)
        {
            return fmod((double)$a * (double)$b, $m);
        }
        private static function inv_mod($x, $y)
        {
            $q = $u = $v = $a = $c = $t = 0;
            $u = $x;
            $v = $y;
            $c = 1;
            $a = 0;
            do
            {
                $q = (int)($v / $u);
                $t = $c;
                $c = $a - $q * $c;
                $a = $t;
                $t = $u;
                $u = $v - $q * $u;
                $v = $t;
            }
            while ($u != 0);
            $a = $a % $y;
            if ($a < 0)
            {
                $a = $y + $a;
            }
            return $a;
        }
        private static function pow_mod($a, $b, $m)
        {
            $r = $aa = 0;
            $r = 1;
            $aa = $a;
            while (1)
            {
                if ($b & 1)
                {
                    $r = self::mul_mod($r, $aa, $m);
                }
                $b = $b >> 1;
                if ($b == 0)
                {
                    break;
                }
                $aa = self::mul_mod($aa, $aa, $m);
            }
            return $r;
        }
        static function  sub($len){
            $lens = ceil ($len / 10) + 2;
            $a = 1;
            $p = '3.';  
            for($i=1;$i<$lens;$i++){
                $v = self::calc($a);
                $p .= $v['v'];
    $a = $a+9;
            }
            return $p;
        }
    }
    echo pi::sub($_GET["pi"]);
?>
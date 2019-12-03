<?php
class FlyModel
{
    /**
     * @param string $url
     */
    public function getHtml()
    {
        $url = 'https://booking.flypeach.com/tw/flight_search/lowest_prices?departure_airport=TPE&arrival_airport=HND&start_date=2019-07-29&end_date=2019-09-01';
        $url = 'https://www.flypeach.com/pc/tw';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $headers = [
        // "Host: booking.flypeach.com",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0",
        // "Accept-Language: zh-TW,zh;q=0.8,en-US;q=0.5,en;q=0.3",
        // "Accept-Encoding: gzip, deflate, br",
        // "X-Requested-With: XMLHttpRequest",
        // "Connection: keep-alive",
        // "Referer: https://booking.flypeach.com/tw/flight_search",
        // "Cookie: ak_bmsc=5F836ABD08C96C3F0BE3F46FFA3859C66874F31E4429000044D0535D3858A005~plprxJb8XwS6w4cOVuJkZFp72fR+pQPRBwCmke/kXdq3cITUPnvMKWSPMZeJ2ZlnHvjMMdQbRW+e7dk2FR6SFHYcj/j+ptOEVlU1GxcSQlx6kPd5ePJ+imZwF5r9l+jyxeFiO4Hq5xuuUQWHSz0ObqSA9tcLz6k1daCjq/qkzy58ouPwgoTnf0aWW86oxylMmu3Bu50YY5OGi4cZDImzZgiTSiz+gqKj23zVhVqBazSGBe16OlMzz0K5I2FL6KONxI; bm_sz=9D97C4C5AFC192004758FCBB07AD1570~YAAQHvN0aMinUH1sAQAAVIpljwQb9QwSNonOHA25axtk+eTfdNOXxUKu/D/W4vUDVUUxcCULgZiuD4/bfQYyWeMxOaMdDTEWkO14H16sRRdDLgHtmGcpKVy7+sRLjDZ3Kf+fu0NrvwdcynsI+sTlzmwFZre3J7ZvsHUl6NRg0m7zSRqx3VJ4HWTCwndXIuJwjA4=; _abck=CC51B61FE75B476446461162CE177417~0~YAAQHvN0aJSvUH1sAQAAxmZvjwLkd37a9Rw/yRR7jkyRW7qRzwwsStHLFEfUNNgiN9ohI8QiCkE7Oa/jtk4HrE9xNFkDQ8EJ1zQBPhwpR0zPLPmQmah2nhS7sY6bq+DRdHzJ/IPPZTA+BH1hQ98KwyDuRIM6SCrSbttDZCq57PuG8nDYJuWOn+/GnuCR4QDlBf0MOpm3MyxfWl7Hl7A5YlhGK/EooBeH0brLxo9wKMiskIADBIPsuSeBdfwQlCnufW+qtA1vSoLLDYDsgEWCSzSUan5BgHstBU/RrHOV9sE+onyIxH7+xMHC5Q==~-1~-1~-1; bm_mi=7F9C2B8912DD919F4F03D65C3BA22757~SUGMBF47cl5yJtvf4gCRRCOtJNWei7I9PrxDlYVVT7hl1s975MbDfgVG2zrrdddocDKze/QB5uuUBaRKfhaD+V2idQa3iTNbFJDAhiLIq2kRvY3FUp7FFk6SI6OlUwOA7bqLNaHvdbzvm5e6KwLd5rHe+wtHzeLyCR1AeC5MiHUQ3nhnBI4NZITYXK1kXwRi4oYSOaFrnzbg7qslLs5unVflpXPmtZOyv9SRsHz2a+Mz7yIdoLKRKIVVeUmf3REG32H//nH0+ps/IeA3LDmvGw==; bm_sv=2E784B58F27646DEA163F9EF972F1C3B~zrz3Gq568ayDjcGpqDZEK3H9gnlxmIcNkuGrMh9Ol6bkas9TYKGOAchtKnLKQzzyrvp9RzKQ+Myo5bjpqcVU83tIPCy6LMd0sg4rwI0E+IPEXz0QyubeKramYC1BYkfGWUHcko5Po0UprZXFb9edsNf2e0r3PQv/Zn9Qrj0ME7o=; _gcl_au=1.1.653881286.1565773895; _ga=GA1.2.1863374649.1565773896; _gid=GA1.2.901671668.1565773896; _fbp=fb.1.1565773897149.982499283; krt.ktid=qMxJ1xO5; krt.vis=qMxJ1xO5; krt.s=date%3A1565773900%3Bpv%3A21%3Btime%3A778; reqid=TDVSaEJ0aWc5SEtNUUtGbDJYd2tQdz09LS1BRkNpQ05MMkhPVjZDeEFjN0ZlTzJ3PT0%3D--e590ab36dd146c9f3816880a94043fc92b45674f; _session_id=4f3dd76c7e38c04af49bf8af1db3ed41; flight_history=%7B%220%22%3A%7B%22departureAirportCode%22%3A%22TPE%22%2C%22arrivalAirportCode%22%3A%22HND%22%2C%22adultCount%22%3A2%2C%22childCount%22%3A0%2C%22infantCount%22%3A0%2C%22isReturn%22%3Atrue%7D%7D; __lt__cid=a6b41e28-60a1-40ae-919c-c6a91bd3d12c; __lt__sid=0e2a8729-1f08606f; displayed_appeal_modal=true; _td=7d749ac2-505b-4b7d-b3da-1e911f575508; _gat=1",
        // "Pragma: no-cache",
        // "Cache-Control: no-cache",
        // "TE: Trailers"
        ];
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        // curl_setopt($ch, CURLOPT_USERAGENT, "user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"); //解决错误：“未将对象引用设置到对象的实例。”
        $res = curl_exec($ch);
        if (!$res) {
            file_put_contents(ROOT_DIR . "/log/FlycurlErrLog.txt", date('Y-m-d H:i:s') . ' curl error: ' . curl_error($ch) . PHP_EOL, FILE_APPEND);
            return false;
        }
        curl_close($ch);
        return $res;
    }
}
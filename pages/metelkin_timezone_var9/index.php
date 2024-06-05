<?php
    function getDayOrMonth(string $type): string
    {
        $days = ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'];
        $months = ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'];

        if ($type === 'd') {
            return $days[date('w')];
        } elseif ($type === 'm') {
            return $months[date('n') - 1];
        }

        return '';
    }

    function getTimezoneInterval(string $timezone): string
    {
        $currentTime = new DateTime('now');
        $moscowTime = new DateTimeZone('Europe/Moscow');
        $timezoneTime = new DateTimeZone($timezone);

        $timezoneOffset = $timezoneTime->getOffset($currentTime) / 3600;
        $moscowOffset = $moscowTime->getOffset($currentTime) / 3600;

        $msk = $timezoneOffset - $moscowOffset;
        $utc = $timezoneOffset;

        $msk = $msk > 0 ? "+" . $msk : $msk;
        $utc = $utc > 0 ? "+" . $utc : $utc;

        return "По МСК " . $msk . "\nПо UTC " . $utc;
    };

    function getTimeNow(string $timezone): string 
    {
        return (new DateTime('now', new DateTimeZone($timezone))) -> format('H:i:s');
    }

    function getTodayInfo(): string
    {
        $currentDate = date('Y-m-d');
        $day = date('d', strtotime($currentDate));
        $month = getDayOrMonth('m');
        $year = date('Y', strtotime($currentDate));

        $dayOfWeek = getDayOrMonth('d');

        return "Сегодня: {$dayOfWeek}<br>день: {$day}\t\t\tмесяц: {$month}\t\t\tгод: {$year}";
    }

?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <table>
        <tr>
            <td colspan='5'><?php echo getTodayInfo(); ?></td>
        </tr>
        <tr>
            <td>Москва</td>
            <td>Таиохае (Французская Полинезия)</td>
            <td>Кочабамба</td>
            <td>Судзука</td>
            <td>Анадырь</td>
        </tr>
        <tr>
            <td rowspan='2'><?php echo getTimeNow('Europe/Moscow'); ?></td>
            <td><?php echo getTimeNow('Pacific/Marquesas'); ?></td>
            <td><?php echo getTimeNow('America/La_Paz'); ?></td>
            <td><?php echo getTimeNow('Asia/Tokyo'); ?></td>
            <td><?php echo getTimeNow('Asia/Anadyr'); ?></td>
        </tr>
        <tr>
            <td><?php echo getTimezoneInterval('Pacific/Marquesas'); ?></td>
            <td><?php echo getTimezoneInterval('America/La_Paz'); ?></td>
            <td><?php echo getTimezoneInterval('Asia/Tokyo'); ?></td>
            <td><?php echo getTimezoneInterval('Asia/Anadyr'); ?></td>
        </tr>
    </table>
</body>
</html>

<?php


class GenreService
{
    public function getGenreStats()
    {
        $sql = 'SELECT g.genre_name, count(b.id) total FROM book b 
join genre g on g.genre_id= b.genre_id
group by g.genre_name order by total';
        $pdo = getPDO();
        $stmt = $pdo->query($sql);
        $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->showAsPercents($stats);

    }

    /**
     * array $stats
     * @return array
     */
    private function showAsPercents($stats): array
    {
        $total = array_column($stats, 'total');
        $totalSum = array_sum($total);
        foreach ($stats as &$stat) {
            $stat['percent'] = round($stat['total'] / $totalSum * 100);
        }


        return $stats;
    }


}
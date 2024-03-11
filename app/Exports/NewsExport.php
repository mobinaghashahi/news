<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Details;
use App\Models\News;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\WithEvents;
use function Sodium\add;

class NewsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function headings(): array
    {
        return [
             "TITLE","DATE", "INSTRUMENT", "EFFECT", "COMMENT","NEWS",
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $col2 = new Collection([]);
        $news = News::join('details','details.news_id','=','news.id')
            ->select('news.title as title','news.created_at as created_at','news.text as text',
                'news.id as id','details.news_id as news_id','details.effect as effect','details.instrument as instrument',
                'details.comment as comment')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($news as $new) {
                $col1 = new Collection([
                    [$new->title,$new->created_at, $new->instrument, "$new->effect", $new->comment, $new->text]
                ]);

                $col2 = $col2->toBase()->merge($col1);

        }

        return $col2;
    }

    public function registerEvents(): array
    {

        return [

            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:F1')->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                $event->sheet->getDelegate()->getStyle('A1:F1')->getFont()
                    ->setBold(true);


                $news = News::join('details','details.news_id','=','news.id')
                    ->select('news.title as title','news.created_at as created_at','news.text as text',
                        'news.id as id','details.news_id as news_id','details.effect as effect','details.instrument as instrument',
                        'details.comment as comment')
                    ->orderBy('id', 'desc')
                    ->get();
                $index = 1;
                $colors = array(4 => "00ff1a", 3 => '33ff48', 2 => '66ff76', 1 => 'b3ffbb', 0 => 'ffffff', -1 => 'ff7070', -2 => 'ff4a4a', -3 => 'ff2424', -4 => 'ff0000');
                foreach ($news as $new) {
                            $event->sheet->getDelegate()->getStyle('D' . $index + 1)->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB($colors[$new->effect]);
                            $index++;
                }

                $event->sheet->getDelegate()->getStyle('A1:F1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('808080');

            },

        ];

    }
}

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
        $news = News::all()->reverse();
        $tags = retriveTags();
        $details = Details::all();
        $added = false;
        $index = 0;
        foreach ($news as $new) {
            foreach ($details as $detail) {
                $col1 = new Collection([
                    [$new->title,$new->created_at, "", "", "", $new->text]
                ]);
                if ($detail->news_id == $new->id) {

                    //صفر را در اکسل نشان نمیداد با این روش این باگ را رفع کردم.
                    if ($detail->effect == 0)
                        $col1 = [
                            [$new->title, $new->created_at, $tags[$detail->id], "0", $detail->comment, $new->text]
                        ];
                    else
                        $col1 = [
                            [$new->title, $new->created_at, $tags[$detail->id], $detail->effect, $detail->comment, $new->text]
                        ];

                    $col2 = $col2->toBase()->merge($col1);
                    $added = true;
                }
            }

            if ($added == false) {
                $col2 = $col2->toBase()->merge($col1);
            }
            $added = false;

        }
        /*$col1=new Collection([
            [1, 2, 3],
            [4, 5, 6]
        ]);
        $col2=new Collection([
            [7, 8, 9]
        ]);
        $merg=$col1->merge($col2);*/

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


                $news = News::all()->reverse();
                $tags = retriveTags();
                $details = Details::all();
                $added = false;
                $index = 1;
                $colors = array(4 => "00ff1a", 3 => '33ff48', 2 => '66ff76', 1 => 'b3ffbb', 0 => 'ffffff', -1 => 'ff7070', -2 => 'ff4a4a', -3 => 'ff2424', -4 => 'ff0000');
                foreach ($news as $new) {
                    foreach ($details as $detail) {
                        if ($detail->news_id == $new->id) {
                            $event->sheet->getDelegate()->getStyle('D' . $index + 1)->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB($colors[$detail->effect]);
                            $index++;
                            $added = true;
                        }
                    }
                    if ($added == false)
                        $index++;
                    $added = false;
                }

                $event->sheet->getDelegate()->getStyle('A1:F1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('808080');

            },

        ];

    }
}

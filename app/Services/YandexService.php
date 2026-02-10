<?php
namespace App\Services;
class YandexService{
    public function getCompanyInfo(string $companyId):array{
        return[
            'rating' => 4.7,
            'reviews_count' => 128,
        ];
    }
    public function getReviews(string $companyId):array{
        return[
            [
                'author' => 'Иван Петров',
                'rating' => 5,
                'text' => 'Отличная компания!',
                'date' => '2024-01-15',
            ],
            [
                'author' => 'Мария Иванова',
                'rating' => 4,
                'text' => 'Все хорошо, но есть мелкие недочёты.',
                'date' => '2024-02-03',
            ],
        ];
    }
}
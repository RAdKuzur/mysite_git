<?php

namespace app\commands\Generator_helpers;

class DocHelper
{
    static $array_name = [
        "Секретный Проект Альфа", "Операция Лунная Тень", "Протокол Океанский Ветер", "Код Черный Лотос",
        "Досье Персей", "Загадка Аметистового Грифа", "Рубиновые Сны", "Миссия Галактический Шторм",
        "Чертежи Звездного Замка", "Секреты Исчезнувшего Артефакта", "Инквизиторский Доклад", "Тень Ледяного Меча",
        "Кодовое Имя Феникс", "Пленницы Звездного Леса", "Алмазный Путь", "Артефакт Хаоса", "Операция Гиперион",
        "Призрак Восточного Моря", "Агент Багровой Розы", "Лабиринт Теней", "Тайна Изгнанника", "Кристалл Лунного Пламени",
        "Отражение Звездного Света", "Кодовое Имя Меркурий", "Звездный Предел", "Протокол Черного Дракона",
        "Дневник Сокровищ Небес", "Авантюра Перезагрузки", "Информационный Водоворот", "Звездная Галактика", "Сотовые Загадки",
        "Легенда Огненного Крыла", "Шифр Янтарного Лабиринта", "Территория Высоких Технологий", "Инквизиторский Архив", "Кодовое Имя Сирин",
        "Магия Космической Тысячи", "Документ 404", "Тень Забытых Времен", "Артефакт Пурпурного Света",
        "Секреты Солнечного Круга", "Королевский Пакт", "Миссия Ночной Крови", "Хроники Звездного Потока", "Инквизиторский Ликвидатор",
        "Аномалия Космической Пустоты", "Шифр Затерянного Легиона", "Доклад Псионической Энергии", "Секреты Звездного Моря",
        "Инструкция Портала Времени"
    ];
    static $array_theme = [
        "Искусственный интеллект и будущее человечества", "Экологические вызовы в современном мире", "История развития космических исследований",
        "Глобальные тенденции в медицине", "Цифровая трансформация бизнеса", "Роль женщин в современном обществе",
        "Технологии будущего: от киберпанка до реальности", "Финансовая устойчивость в условиях неопределенности", "Искусство и культура в эпоху глобализации",
        "Психология счастья и благополучия", "Модернизация городской инфраструктуры", "Здоровый образ жизни и профилактика заболеваний",
        "Этика и права животных", "Инновации в образовании: вызовы и перспективы", "Исследование человеческого мозга: достижения и перспективы",
        "Тайны древних цивилизаций", "Развитие туризма в XXI веке", "Интернет вещей: перспективы применения",
        "Борьба с климатическими изменениями", "Социальная ответственность бизнеса", "Криптовалюты и будущее финансовых рынков",
        "Роль и влияние медиа в современном обществе", "Индустрия развлечений и культурные стереотипы", "Новые технологии в сфере медицины",
        "История искусства: взгляд из современности", "Роботизация труда: вызовы и возможности", "Кризисы и управление рисками в бизнесе",
        "Экономическое развитие в посткоронавирусный период", "Права человека в цифровую эпоху", "Автоматизация и искусственный интеллект",
        "История индустриальной революции", "Роль гендера в обществе и бизнесе", "Теории общественного развития",
        "Культурное многообразие и единство", "Энергетическая безопасность и альтернативные источники энергии", "История медицины и медицинские открытия",
        "Интерактивные технологии в образовании", "Религия и современность: диалог культур", "Цифровая безопасность и угрозы интернета",
        "Исследование мегаполисов и урбанистика", "Инновации в секторе питания и сельском хозяйстве", "Футуристические технологии и общество завтрашнего дня",
        "Экологическая устойчивость и возобновляемые ресурсы", "История и философия науки", "Международные конфликты и дипломатия",
        "Технологии блокчейн и криптовалют","Семейные ценности и современное поколение", "Инфляция и монетарная политика",
        "Искусство кино: история и современность", "Исследование космической бездны и других миров"
    ];
    static $array_keywords = [
        "Исследование", "Анализ", "Стратегия", "Развитие", "Инновации", "Технологии", "Устойчивость",
        "Эффективность", "Конкуренция", "Качество", "Цифровизация", "Экосистема", "Глобализация", "Трансформация", "Импакт",
        "Диверсификация", "Автоматизация", "Адаптация", "Экология", "Интеграция", "Клиентоориентированность", "Инклюзивность",
        "Безопасность", "Инфраструктура", "Лидерство", "Партнерство", "Эксперимент", "Социальная ответственность",
        "Монетизация", "Цифровая трансформация", "Экспансия", "Аналитика", "Кооперация", "Маркетинг", "Индустриализация",
        "Финансы", "Ответственность", "Дивиденды", "Управление", "Предпринимательство", "Потребитель", "Инженерия",
        "Коммуникации", "Инклюзивный рост", "Интерактивность", "Креативность", "Риски", "Энергия", "Урбанизация",
        "Экосистемная экономика"
    ];
    function splitFile($inputString) {
        // Разбить строку на слова, используя пробел в качестве разделителя
        $fileArray = explode(" ", $inputString);
        // Удалить пустые элементы, которые могли возникнуть из-за нескольких пробелов подряд
        $fileArray = array_filter($fileArray, 'strlen');
        return $fileArray;
    }
    static $createQueryTableFirst = 'CREATE TABLE u1471742_index.files_tmp (
                id INT AUTO_INCREMENT PRIMARY KEY,
                                          table_name VARCHAR(255) NOT NULL,
                                          table_row_id INT NOT NULL,
                                          file_type VARCHAR(1000) NOT NULL,
                                          filepath VARCHAR(1000) NOT NULL
)';
    static $createQueryTableSecond = 'CREATE TABLE u1471742_index.files_tmp_2 (
        id INT AUTO_INCREMENT PRIMARY KEY,
                                            table_name VARCHAR(1000) NOT NULL,
                                            table_row_id INT NOT NULL,
                                            file_type VARCHAR(1000) NOT NULL,
                                            filepath VARCHAR(1000) NOT NULL
);';
    static $createQueryTableThird = 'CREATE TABLE u1471742_index.files_tmp_3 (
        id INT AUTO_INCREMENT PRIMARY KEY,
                                            table_name VARCHAR(1000) NOT NULL,
                                            table_row_id INT NOT NULL,
                                            file_type VARCHAR(1000) NOT NULL,
                                            filepath VARCHAR(1000) NOT NULL
)';
    static $insertDocInDoc = "INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
                                SELECT 'document_in', `id`, 'doc', `doc`
                                FROM u1471742_index.`document_in`
                                WHERE `doc` != '';";

    static $insertDocInScan = "INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
                                SELECT 'document_in', `id`, 'scan', `scan`
                                FROM u1471742_index.`document_in`
                                WHERE `scan` != '';";

    static $insertDocInApplication = "INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
                                SELECT 'document_in', `id`, 'application', `applications`
                                FROM u1471742_index.`document_in`
                                WHERE `applications` != '';";
    static $splitDocIn = "INSERT INTO u1471742_index.files_tmp_2 (`table_name`, `table_row_id`, `file_type`, `filepath`)
                                SELECT `table_name`, `table_row_id`, `file_type`, SUBSTRING_INDEX(SUBSTRING_INDEX(`filepath`, ' ', n), ' ', -1) AS filepath
                                FROM u1471742_index.files_tmp, (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4  UNION ALL SELECT 5
                                UNION ALL SELECT 6  UNION ALL SELECT 7  UNION ALL SELECT 8  UNION ALL SELECT 9
                                UNION ALL SELECT 10  UNION ALL SELECT 11) numbers
                                WHERE n <= 1 + (LENGTH(`filepath`) - LENGTH(REPLACE(`filepath`, ' ', '')));";
    static $firstCopyDocIn  =  "INSERT INTO u1471742_index.files_tmp_3 (`table_name`, `table_row_id`, `file_type`, `filepath`)
                                SELECT `table_name`, `table_row_id`, `file_type`, `filepath`
                                FROM u1471742_index.files_tmp_2
                                WHERE `filepath` != '';";
    static $deleteEmptyDocIn = "DELETE t1
                                FROM u1471742_index.files_tmp_3 t1
                                INNER JOIN u1471742_index.files_tmp_3 t2
                                WHERE t1.filepath = t2.filepath AND t1.id > t2.id;";
    static $secondCopyDocIn =  "SELECT `table_name`,`table_row_id`, `file_type`, `filepath`
                                FROM u1471742_index.files_tmp_3;";
    static $dropTableDocIn = "DROP TABLE u1471742_index.files_tmp;
                                DROP TABLE u1471742_index.files_tmp_2;
                                DROP TABLE u1471742_index.files_tmp_3;";
    static $dropTableFirstDocIn = "DROP TABLE u1471742_index.files_tmp;";
    static $dropTableSecondDocIn = "DROP TABLE u1471742_index.files_tmp_2;";
    static $dropTableThirdDocIn = "DROP TABLE u1471742_index.files_tmp_3;";
    static $getDocInTable = "SELECT *
                                FROM u1471742_index.`document_in`";
}
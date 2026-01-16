
INSERT INTO questions (test_id,text,type) VALUES
    (1,'Что такое DPI?','choice'),
    (1,'Что означает ACL?','choice'),
    (1,'Какая команда проверяет открытые порты в Linux?','choice'),
    (1,'Что такое NAT?','choice'),
    (1,'Что такое VLAN?','choice');

INSERT INTO answers (question_id,text,is_correct) VALUES
    (1,'Deep Packet Inspection',1),
    (1,'Digital Processing Index',0),
    (1,'Data Packet Interval',0),
    (2,'Access Control List',1),
    (2,'Application Control Layer',0),
    (2,'Automatic Connection Link',0),
    (3,'nmap',1),
    (3,'ping',0),
    (3,'traceroute',0),
    (4,'Network Address Translation',1),
    (4,'Network Access Terminal',0),
    (4,'Network Advanced Technology',0),
    (5,'Virtual LAN',1),
    (5,'Virtual Link Area',0),
    (5,'Virtual Layer Access',0);

INSERT INTO questions (test_id,text,type) VALUES
    (2,'Какой протокол шифрует данные при передаче в браузере?','choice'),
    (2,'Что такое AES?','choice'),
    (2,'Что такое RSA?','choice'),
    (2,'Что такое хеш-функция?','choice'),
    (2,'Что такое цифровая подпись?','choice');

INSERT INTO answers (question_id,text,is_correct) VALUES
    (6,'HTTPS',1),
    (6,'HTTP',0),
    (6,'FTP',0),
    (7,'Advanced Encryption Standard',1),
    (7,'Asymmetric Encryption System',0),
    (7,'Automated Encryption Scheme',0),
    (8,'Алгоритм с открытым ключом',1),
    (8,'Симметричный алгоритм',0),
    (8,'Протокол VPN',0),
    (9,'Односторонняя функция для проверки целостности',1),
    (9,'Шифрование с секретным ключом',0),
    (9,'Сжатие данных',0),
    (10,'Механизм подтверждения подлинности и целостности данных',1),
    (10,'Протокол шифрования',0),
    (10,'Секретный пароль',0);

INSERT INTO questions (test_id,text,type) VALUES
    (3,'Какая команда в Linux выводит список процессов?','choice'),
    (3,'Что делает chmod 700 файл?','choice'),
    (3,'Что такое sudo?','choice'),
    (3,'Что такое журналирование в Windows?','choice'),
    (3,'Какой порт по умолчанию для SSH?','choice');

INSERT INTO answers (question_id,text,is_correct) VALUES
    (11,'ps',1),
    (11,'ls',0),
    (11,'top',0),
    (12,'Даёт полные права владельцу и запрещает всем остальным',1),
    (12,'Делает файл скрытым',0),
    (12,'Создаёт нового пользователя',0),
    (13,'Выполнение команды с правами суперпользователя',1),
    (13,'Создание нового пользователя',0),
    (13,'Удаление файла',0),
    (14,'Сбор и хранение событий для аудита',1),
    (14,'Шифрование данных',0),
    (14,'Запуск антивируса',0),
    (15,'22',1),
    (15,'21',0),
    (15,'23',0);

INSERT INTO tests (title, description) VALUES
    ('Сети и инфраструктура','Вопросы про сетевые протоколы, ACL, NAT, VLAN'),
    ('Криптография','Вопросы про шифрование, протоколы, цифровые подписи'),
    ('Безопасность ОС','Вопросы про Linux/Windows, команды и политики безопасности');
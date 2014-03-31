<?php
/*First, we filter the input*/
$sqlserver = filter_input(INPUT_GET, 'sql-server', FILTER_SANITIZE_SPECIAL_CHARS);
$sqluser = filter_input(INPUT_GET, 'sql-username', FILTER_SANITIZE_SPECIAL_CHARS);
$sqlpass = filter_input(INPUT_GET, 'sql-password', FILTER_SANITIZE_SPECIAL_CHARS);
$sqldb = filter_input(INPUT_GET, 'sql-db', FILTER_SANITIZE_SPECIAL_CHARS);
$admin_user = filter_input(INPUT_GET, 'admin-username', FILTER_SANITIZE_SPECIAL_CHARS);
$admin_pass = filter_input(INPUT_GET, 'admin-password', FILTER_SANITIZE_SPECIAL_CHARS);
$title = filter_input(INPUT_GET, 'set-title', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_GET, 'set-email', FILTER_SANITIZE_SPECIAL_CHARS);
$users_system = (filter_input(INPUT_GET, 'set-usersystem', FILTER_SANITIZE_SPECIAL_CHARS)) ? 1 : 0;
$users_registration = (filter_input(INPUT_GET, 'set-registration', FILTER_SANITIZE_SPECIAL_CHARS)) ? 1 : 0;
$lang = filter_input(INPUT_GET, 'langselect', FILTER_SANITIZE_SPECIAL_CHARS);
$lang_en = (filter_input(INPUT_GET, 'langs-en', FILTER_SANITIZE_SPECIAL_CHARS)) ? 1 : 0;
$lang_de = (filter_input(INPUT_GET, 'langs-de', FILTER_SANITIZE_SPECIAL_CHARS)) ? 1 : 0;
$lang_es = (filter_input(INPUT_GET, 'langs-es', FILTER_SANITIZE_SPECIAL_CHARS)) ? 1 : 0;
$lang_tr = (filter_input(INPUT_GET, 'langs-tr', FILTER_SANITIZE_SPECIAL_CHARS)) ? 1 : 0;
$lang_ru = (filter_input(INPUT_GET, 'langs-ru', FILTER_SANITIZE_SPECIAL_CHARS)) ? 1 : 0;
$lang_zh = (filter_input(INPUT_GET, 'langs-zh', FILTER_SANITIZE_SPECIAL_CHARS)) ? 1 : 0;

/* Connects to database*/
$conexion = mysqli_connect($sqlserver, $sqluser, $sqlpass); //Connects to the server
if(!$conexion) die('Could not connect: ' . mysqli_error($conexion));

mysqli_select_db($conexion, $sqldb) or die('Could not connect to database: ' . mysqli_error($conexion)); //Connect to database

/* Now we create the config.php file */
$configfile = fopen("../config.php","w") or die('Error trying to create config.php file'); //Create the file

fwrite($configfile,'<?php
$mysql_server = "$sqlserver";
$mysql_user = "'.$sqluser.'";
$mysql_pass = "'.$sqlpass.'";
$mysql_db = "'.$sqldb.'";
$admin_user = "'.$admin_user.'";
$admin_pass = "'.$admin_pass.'";
?>');


/* Create the tables of the database */
mysqli_query($conexion, 'CREATE TABLE `CODE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `file` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `route` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `atstart` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `COMMENTS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `ticketid` int(11) NOT NULL,
  `isstaff` tinyint(1) NOT NULL,
  `userid` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `username` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `DEPARTMENTS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'INSERT INTO DEPARTMENTS VALUES("","Test Department")');

mysqli_query($conexion, 'CREATE TABLE `DOCS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `by` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `file` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `EXTRA` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `type` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `plugin` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `toid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `INFO` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `value` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `LANG` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `short` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `supported` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'INSERT INTO LANG VALUES("","English","en","'. $lang_en .'")');
mysqli_query($conexion, 'INSERT INTO LANG VALUES("","Deutsch","de","'. $lang_de .'")');
mysqli_query($conexion, 'INSERT INTO LANG VALUES("","Español","es","'. $lang_es .'")');
mysqli_query($conexion, 'INSERT INTO LANG VALUES("","Turkish","tr","'. $lang_tr .'")');
mysqli_query($conexion, 'INSERT INTO LANG VALUES("","Russian","ru","'. $lang_ru .'")');
mysqli_query($conexion, 'INSERT INTO LANG VALUES("","Chinese","zh","'. $lang_zh .'")');

mysqli_query($conexion, 'CREATE TABLE `LOGS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `MODES` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `route` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `file` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `PLUGINS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `author` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `version` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `PROPERTIES` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `type` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `value` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `edit` tinyint(1) NOT NULL,
  `input` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `filter` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `STAFF` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `user` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pass` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `tickets` int(11) NOT NULL,
  `departments` text COLLATE utf8_unicode_ci NOT NULL,
  `manage` tinyint(1) NOT NULL,
  `docs` tinyint(1) NOT NULL,
  `langs` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `STAFFLOG` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `log` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `TEXT` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lang` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `type` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `plugin` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'INSERT INTO TEXT VALUES("1","Mail:1","Hello!<div>You have a Staff account in&nbsp;</div>","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("4","Mail:7","Your staff account has been deleted.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("5","Mail:6","Thank you for register in our support center.<div>You can login using the following link:</div>","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("6","Mail:5","You\'ve sent a new ticket to our support center.<div>You can read it when you login in our system:&nbsp;</div>","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("7","Mail:4","You\'ve sent a new ticket to our support center.<div>You can read it using the following link:&nbsp;</div>","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("8","Mail:3","Your ticket has been answered.<div>Please visit the following link: &nbsp;</div>","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("9","Mail:2","Hello!<div>Your Staff account in has been updated in&nbsp;</div>","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("10","Welcometext","Welcome to our support center. You can contact us through a tickets system. Your tickets will be answered by our staff.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("11","New Ticket Description","Create a ticket is the way to communicate with our support center. Your ticket will be answered by our staff as soon as we can. You will be informed by email when it is answered.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("12","Submit a ticket description","Click here to send us a support ticket","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("13","Check Your Ticket description","Here you can check the status of your ticket.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("14","Create an User description","Create an user to send tickets and see the documentation.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("15","About Articles description","You can see articles and documents published by our staff.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("16","Submitted Tickets Description","This is the list of the tickets you have sent to our support staff.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("17","Docs and Guides description","Here you have a list of documents, guides and articles which have been made by our staff members.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("18","Edit Profile description","You can modify your profile here.","en","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("19","Mail:6","感谢您注册我们的支持中心.\n您可以使用下面的链接登录: ","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("29","Mail:6","Bizim destek merkezini kullanmak için teşekkür ederiz.\nSen Aşağıdaki linki kullanarak giriş yapabilirsiniz: ","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("71","Mail:7","Ваша учетная запись был удален.","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("70","Mail:7","您的的帐户已被删除","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("69","Mail:7","Sizin hesabı silindi.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("68","Mail:1","Здравствуйте!\nУ вас есть аккаунт сотрудников в ","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("67","Mail:1","您好！\n你有一个新的帐户。 ","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("66","Mail:1","Merhaba!\nSen bir personel hesabı var ","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("34","Mail:1","Hola!\nTienes una nueva cuenta de Staff en","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("35","Mail:7","Su cuenta de staff ha sido borrada.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("36","Mail:6","Gracias por registrarse en nuestro centro de soporte.\nPuedes ingresar al sistema usando el siguiente enlace: ","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("37","Mail:5","Has enviado un nuevo ticket a nuestro centro de soporte.\nPudes verlo cuando ingresea nuestro sistema aqui: ","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("38","Mail:4","Has enviado un nuevo ticket a nuestro centro de soporte.\nPuedes verlo usando el siguiente enlace: ","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("39","Mail:3","Su ticket a sido respondido\nPor favor, visita el siguiente enlace: ","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("40","Mail:2","Hola!\nSu cuenta de staff ha sido actualizada en ","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("41","Welcometext","Bienvenido a nuestro centro de soporte. Usted puede contactarlos a través de tickets. Sus tickets serán respondidos por nuestro staff.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("42","New Ticket Description","Crear un ticket es la manera de communicarse con nuestro centro de soporte. Su ticket será respondido tan pronto como sea posible. Le será notificado por correo electronico cuando lo esté.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("43","Submit a ticket description","Haga click aquí para enviarnos un ticket de soporte","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("44","Check Your Ticket description","Aquí puede ver el estado de su ticket.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("45","Create an User description","Cree un usuario para enviar tickets y ver la documentación.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("46","About Articles description","Puedes ver documentos y articulos publicados por nuestro staff.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("47","Submitted Tickets Description","Esta es la lista de tickets que usted ha enviado a nuestro centro de soporte.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("48","Docs and Guides description","Aquí tiene una lista de documentos, articulos y guias que han sido escritas por nuestro staff.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("49","Edit Profile description","Usted puede modifacar las preferencias de su cuenta en este lugar.","es","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("50","Mail:1","Hallo!\nSie haben eine neue Staff Konto in ","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("51","Mail:7","Ihre Staff Konto wurde gelöscht.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("52","Mail:6","Vielen Dank für Register in unserem Support-Center.\nSie können sich anmelden unter folgendem Link: ","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("53","Mail:5","Sie haben ein neues Ticket an unseren Support gesendet.\nSie können Sie lesen, wenn Sie in das System einloggen: ","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("54","Mail:4","Sie haben ein neues Ticket an unseren Support gesendet.\nSie können es unter folgendem Link lesen: ","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("55","Mail:3","Ihr Ticket beantwortet wurde\nBitte besuchen Sie den folgenden Link: ","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("56","Mail:2","Hallo!\nIhre Mitarbeiter Konto wurde aktualisiert: ","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("57","Welcometext","Herzlich Willkommen auf unserer Support-Center. Sie können uns durch eine Ticket-System zu kontaktieren. Ihre Tickets werden von unseren Staff beantwortet werden.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("58","New Ticket Description","Erstellen Sie ein Ticket ist der Weg, um mit unserem Support-Center kommunizieren. Ihr Ticket wird von unseren Staff so schnell, wie wir können beantwortet werden. Sie werden per E-Mail informiert, wenn es beantwortet werden.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("59","Submit a ticket description","Klicken Sie hier, um uns eine Support-Ticket","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("60","Check Your Ticket description","Hier können Sie den Status Ihres Tickets überprüfen.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("61","Create an User description","Erstellen Sie einen Benutzer, um Tickets zu senden und in der Dokumentation.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("62","About Articles description","Sie können Artikel und Dokumente von unseren Staff veröffentlicht zu sehen.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("63","Submitted Tickets Description","Dies ist die Liste der Tickets, die Sie an unser Support-Staff gesendet haben.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("64","Docs and Guides description","Hier haben Sie eine Liste der Dokumente, Anleitungen und Artikel, die von unseren Staff vorgenommen wurden.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("65","Edit Profile description","Sie können Ihr Profil hier ändern.","de","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("74","Mail:6","Спасибо за регистре в наш центр поддержки.\nВы можете войти, используя следующую ссылку: ","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("75","Mail:5","Bizim destek merkezine yeni bir bilet gönderdiğiniz.\nEğer sisteme giriş zaman okuyabilirsiniz: ","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("76","Mail:5","你发一张新票给我们的支持中心.\n你可以看到它时，你在我们的系统登录: ","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("77","Mail:5","Вы отправили новый билет в наш центр поддержки.\n\Вы можете прочитать его, когда вы входите в нашей системе: ","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("78","Mail:4","Bizim destek merkezine yeni bir bilet gönderdiğiniz.\nAşağıdaki linki kullanarak okuyabilirsiniz: ","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("79","Mail:4","你发一张新票给我们的支持中心.\n您可以使用下面的链接看看吧: ","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("80","Mail:4","Вы отправили новый билет в наш центр поддержки.\nВы можете прочитать его по следующей ссылке: ","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("81","Mail:3","Sizin bilet olmuştur yanıtladı\nPAşağıdaki bağlantıyı ziyaret edin: ","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("82","Mail:3","您的车票已经回答\n请访问以下链接: ","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("83","Mail:3","Ваш билет был дан ответ\n\Пожалуйста, перейдите по следующей ссылке: ","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("84","Mail:2","Hello!\nHesabınız güncellendi: ","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("85","Mail:2","您好！\n您的帐户已更新  ","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("86","Mail:2","Здравствуйте!\nВаша учетная запись в был обновлен в ","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("87","Welcometext","Bizim destek merkezine hoş geldiniz. Bir bilet sistemi aracılığıyla bize ulaşabilirsiniz. Biletlerinizi personelimiz tarafından cevap verilecektir.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("88","Welcometext","欢迎访问我们的支持中心。您可以通过票系统与我们联系。您的门票将通过我们的工作人员来回答。","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("89","Welcometext","Добро пожаловать в наш центр поддержки. Вы можете связаться с нами через систему билетов. Ваши билеты будет отвечать нашим персоналом.","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("90","New Ticket Description","Bir bilet bizim destek merkezi ile iletişim için bir yoldur. Sizin bilet kısa sürede personelimiz tarafından cevap verilecektir. Bilet cevapladıktan sonra, e-posta ile bildirim alacak.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("91","New Ticket Description","您可以通过发送一票与我们联系。只要我们能，我们将回答你的票。您将通过电子邮件收到通知时，它回答。","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("92","New Ticket Description","Создание билет является способом общения с нашем центре поддержки. Ваш билет будет отвечать нашей штаба, как только мы можем. Вы будете проинформированы по электронной почте, когда он будет дан ответ.","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("93","Submit a ticket description","Bize destek bileti göndermek için buraya tıklayın.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("94","Submit a ticket description","点击这里给我们一个支持票","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("95","Submit a ticket description","Нажмите здесь, чтобы отправить нам в билет поддержки","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("96","Check Your Ticket description","Burada bilet durumunu kontrol edebilirsiniz.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("97","Check Your Ticket description","在这里，你可以检查你的票的状态","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("98","Check Your Ticket description","Здесь Вы можете проверить состояние вашего билета.","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("99","Create an User description","Bilet göndermek için bir kullanıcı oluştur.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("100","Create an User description","创建要发送门票的用户","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("101","Create an User description","Создайте пользователя для отправки билеты и посмотреть документацию.","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("102","About Articles description","Sen yayımlanmış belgeleri ve makaleleri görebilirsiniz","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("103","About Articles description","你可以看到我们的工作人员发表的文章和文件","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("104","About Articles description","Вы можете видеть, статьи и документы, опубликованные нашими сотрудниками.","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("105","Submitted Tickets Description","Bu bizim destek merkezine gönderdiğiniz adres bilet listesi.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("106","Submitted Tickets Description","这是您所发送的门票列表","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("107","Submitted Tickets Description","Это список из билетов вы посланных к нашему штабу.","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("108","Docs and Guides description","Bu bizim Personnel tarafından yapılan belgelerin listesi.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("109","Docs and Guides description","在这里，你有文件，指南和物品都已经由我们的工作人员名单。","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("110","Docs and Guides description","Здесь у вас есть список документов, руководств и статей, которые были сделаны нашими сотрудниками.","ru","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("111","Edit Profile description","Burada profilinizi değiştirebilirsiniz.","tr","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("112","Edit Profile description","你可以在这里修改您的个人资料。","zh","text","no")');
mysqli_query($conexion, 'INSERT INTO TEXT VALUES("113","Edit Profile description","Вы можете изменить свой ​​профиль здесь.","ru","text","no")');

mysqli_query($conexion, 'CREATE TABLE `TICKETS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `department` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `userid` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `isclosed` tinyint(1) NOT NULL,
  `date` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `last` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `lang` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `staffuser` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `isnew` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

mysqli_query($conexion, 'CREATE TABLE `USERS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `password` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;') or die('Error SQL: ' . mysqli_error($conexion));


/* Adds configuration settings to INFO table*/
mysqli_query($conexion, "INSERT INTO INFO VALUES('1','login','$users_system')");
mysqli_query($conexion, "INSERT INTO INFO VALUES('2','register','$users_registration')");
mysqli_query($conexion, "INSERT INTO INFO VALUES('3','lang','$lang')");
mysqli_query($conexion, "INSERT INTO INFO VALUES('4','theme','base')");
mysqli_query($conexion, "INSERT INTO INFO VALUES('5','version','3.0.1')");
mysqli_query($conexion, "INSERT INTO INFO VALUES('6','title','$title')");
mysqli_query($conexion, "INSERT INTO INFO VALUES('7','mainmail','$email')");
mysqli_query($conexion, "INSERT INTO INFO VALUES('8','maintenance','0')");
mysqli_query($conexion, "INSERT INTO INFO VALUES('9','actualversion','3.0.1')");



/* Sends an Email to the administrator */
$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$url = dirname($url);
$url = dirname($url);
$url .= '/admin/';

$headers = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type: text/html";
$headers[] = "From: ".$title." - Support Center <$email>";
$headers[] = "Reply-To: $title - Support Center <$email>";
$headers[] = "X-Mailer: PHP/".phpversion();
$message = "Hello,<br> you have installed OpenSupports 3 in your website<br>Login here: $url<br>Admin User: $admin_user<br>Admin Password:$admin_pass<br>We recommend you to visit http://www.opensupports.com/videotutorials/ where you will find useful tutorials<br>Or visit the forum www.opensupports.com/forum/ to join the community.";
mail($email, 'New OpenSupports installation', $message, implode("\r\n", $headers));

/* DELETE the installation files */
unlink('index.php');
unlink('install.php');

/* Redirects to ../admin/ */
header('Location: ../admin/');
?>
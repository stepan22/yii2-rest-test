<?php
namespace common\models;

use yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

use common\models\Users;
use common\models\Companies;
use common\models\CompanySettings;
use common\models\CompanyUsers;
use common\models\CompanySites;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $phone;
    public $password;
    public $verifyCode;
    public $agreed;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'trim'],
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => '\common\models\Users', 'message' => Yii::t('app', 'This email address has already been taken.')],
            [['email'], 'string', 'max' => 100],

            [['phone'], 'required'],
            [['phone'], 'unique', 'targetClass' => '\common\models\Users', 'message' => Yii::t('app', 'This phone number has already been taken.')],
            //[['phone'], 'match', 'pattern' => '/^(\+?7|7|8)/', 'message' => Yii::t('app', 'This phone number is not valid.')],
			[['phone'], 'string', 'max' => 20],

            [['password'], 'required'],
            [['password'], 'string', 'min' => 6, 'max' => 255],
            
            //[['verifyCode'], 'captcha'],
            //[['verifyCode'], 'required'],
            //[['agreed'], 'required', 'on' => 'LicenseAgreement', 'message' = >'bla-bla-bla'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'password' => Yii::t('app', 'Password'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return Users|null the saved model or null if saving fails
     */
    public function signup($tariff = 'start')
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new Users();
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            // the following three lines were added:
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('company_admin');
            $userTariff = $auth->getRole('tariff_'.$tariff);
            $auth->assign($userRole, $user->getId());
            $auth->assign($userTariff, $user->getId());

			$admin_id = ArrayHelper::getValue($user, 'id');

			$companies = new Companies();
			$companies->admin_id = $admin_id;
			if ($companies->save()) {}

			$company_id = ArrayHelper::getValue($companies, 'id');

			$company_settings = new CompanySettings();
			$company_settings->company_id = $company_id;
            $company_settings->messages = [
                'bot_hello' => "Привет! Я бот компании!\n\nЧтобы продолжить воспользуйтесь клавиатурой: 👇",
                'bot_contact' => 'Введите номер телефона или нажмите кнопку «Приложить контакт»',
                'bot_finish' => '✅ Ваш заказ был принят!
              Ожидайте звонка нашего менеджера в ближайшее время.',
                'bot_help' => 'По всем вопросам пишите нам через этот раздел.',
            ];
            /*
            $company_settings->buttons = [
                'bot_hello' => 'Привет! Я бот компании {company_name}!',
                'bot_contact' => 'Введите адрес и номер телефона или нажмите кнопку «Приложить контакт»',
                'bot_finish' => '✅ Ваш заказ был принят!
              Ожидайте звонка нашего менеджера в ближайшее время.',
                'bot_help' => 'По всем вопросам пишите нам через этот раздел.',
            ];
            $company_settings->commands = [
                'bot_hello' => 'Привет! Я бот компании {company_name}!',
                'bot_contact' => 'Введите адрес и номер телефона или нажмите кнопку «Приложить контакт»',
                'bot_finish' => '✅ Ваш заказ был принят!
              Ожидайте звонка нашего менеджера в ближайшее время.',
                'bot_help' => 'По всем вопросам пишите нам через этот раздел.',
            ];
            */
			if ($company_settings->save()) {}

			$company_sites = new CompanySites();
			$company_sites->company_id = $company_id;
			$company_sites->header_hello = "Добро пожаловать!";
			$company_sites->header_desc = "Свяжитесь со мной удобным для вас способом";

			$buttons = [
				'instagram' => [
					'title' => 'Instagram',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
				'facebook' => [
					'title' => 'Facebook',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
				'facebook-messenger' => [
					'title' => 'Messenger',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
				'skype' => [
					'title' => 'Skype',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
				'telegram' => [
					'title' => 'Telegram',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
				'viber' => [
					'title' => 'Viber',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
				'vk' => [
					'title' => 'VK',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
				'wechat' => [
					'title' => 'WeChat',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
				'whatsapp' => [
					'title' => 'WhatsApp',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
			];

			$links = [
				[
					'title' => 'Link',
					'href' => null,
					'style' => null,
					'sort' => 0,
					'row' => 0,
					'isActive' => 0,
				],
			];

			$colors = [
				'header_background' => '#adff2f',
				'header_text_color' => '#ffffff',
				'header_desc_text_color' => '#ffffff',
				'user_name_color' => '#ffffff',
				'user_desc_text_color' => '#808080',
				'background_color' => '#ffffff',
				'text_color' => '#000000',
			];

			$company_sites->buttons = $buttons;
			$company_sites->links = $links;
			$company_sites->colors = $colors;

			if ($company_sites->save()) {}

			$company_users = new CompanyUsers();
			$company_users->user_id = $admin_id;
			$company_users->company_id = $company_id;
			if ($company_users->save()) {}

            /*
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($settings->book_email)
                ->setSubject('У вас новый заказ!')
                ->setTextBody('Новый заказ на сайте: <a href="'.$input['url'].'">Посмотреть</a>')
                ->setHtmlBody('Новый заказ на сайте: <a href="'.$input['url'].'">Посмотреть</a>')
                // ->setTextBody('Ваш пароль: '.$html_password)
                // ->setHtmlBody('Ваш пароль: '.$html_password)
                ->send();
            */
            return $user;
        } else {
            return null;
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
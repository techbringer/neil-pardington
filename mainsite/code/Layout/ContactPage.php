<?php
use SaltedHerring\Debugger;
use SaltedHerring\RPC;
use SaltedHerring\Grid;

class ContactPage extends Page {

    private static $db = array(
        'SubTitle'                  =>  'Varchar(16)',
        'Recipient'                 =>  'Varchar(254)',
        'Latitude'                  =>  'Varchar(64)',
        'Longitude'                 =>  'Varchar(64)',
        'FindUsGuide'               =>  'HTMLText',
        'MarkerTitle'               =>  'Varchar(48)',
        'MarkerContent'             =>  'Text',
        'Postal'                    =>  'Varchar(1024)',
        'Physical'                  =>  'Varchar(1024)'
    );

    private static $has_one = array(
    );

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Directors'     =>  'BusinessDirector'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            'Root.Main',
            array(
                TextField::create('SubTitle'),
                EmailField::create('Recipient')->setDescription('This is will be the email address that is going to receive email from the contact form.')
            ),
            'URLSegment'
        );

        if ($this->exists()) {
            $fields->addFieldToTab(
                'Root.Directors',
                Grid::make('Directors', 'Directors', $this->Directors())
            );
        }

        $fields->addFieldsToTab(
            'Root.Locations',
            [
                TextField::create(
                    'Postal',
                    'Postal address'
                ),
                TextField::create(
                    'Physical',
                    'Physical address'
                )
            ]
        );

        // $fields->addFieldsToTab(
        //     'Root.GoogleMap',
        //     array(
        //         TextField::create('Latitude'),
        //         TextField::create('Longitude'),
        //         HTMLEditorField::create('FindUsGuide', 'Technical Support Content'),
        //         TextField::create('MarkerTitle'),
        //         TextareaField::create('MarkerContent')
        //     )
        // );

        return $fields;
    }
}


class ContactPage_Controller extends Page_Controller {

    protected static $allowed_actions = array('getForm', 'doSubmit');

    public function getForm() {

        $fields = new FieldList(
            // $name = new TextField('Name'),
            // $company = new TextField('Company'),
            $email = new EmailField('Email', ''),
            $phone = new TextField('Phone', ''),
            $msg = new TextareaField('Message', '')
        );

        $email->setAttribute('placeholder', 'Email address');
        $phone->setAttribute('placeholder', 'Telephone number');
        $msg->setAttribute('placeholder', 'Describe the issue or problem');

        $actions = new FieldList(
            $recaptcha = new LiteralField('Recapture', '<div class="g-recaptcha" data-sitekey="6LdPOSUTAAAAAOky1g7xLpGGwktxgo9jeQaJZVyJ"></div>'),
            new FormAction(
                'doSubmit',
                'Submit'
            )
        );

        $required = new RequiredFields(
            array(
                $email,
                $msg
            )
        );

        $form = new Form($this, 'contactForm', $fields, $actions, $required);
        $form->setFormMethod('POST',true);
        $form->setFormAction(Controller::join_links(BASE_URL, "contact-us", "getForm"));

        return $form;
    }

    public function doSubmit($data, $form) {

        $security_id = $data['SecurityID'];

        if ($security_id != Session::get('SecurityID')) {
            $form->sessionMessage('Invalid security ID', 'bad');
            return Controller::curr()->redirectBack();
        }

        $gstring = $data['g-recaptcha-response'];
        $params = array(
            'secret'    =>  '6LdPOSUTAAAAAOAZ-hP7SOs5iF79xr5TQU2GkNaI',
            'response'  =>  $gstring
        );

        if ($respond = RPC::send('https://www.google.com/recaptcha/api/siteverify', $params)) {
            $respond = json_decode($respond);
            if ($respond->success == 1) {

                if (!empty($this->Recipient)) {
                    $recipient = $this->Recipient;
                } else {
                    $recipient = 'leochenftw@gmail.com';
                }

                $date = new DateTime();
                $msg_body = 'Received: ' . $date->format('Y-m-d H:i:s') . '<br />';
                if (!empty($data['Name'])) { $msg_body .= 'Name: ' . $data['Name'] . "<br />"; }
                if (!empty($data['Company'])) { $msg_body .= 'Company: ' . $data['Company'] . "<br />"; }
                if (!empty($data['Email'])) { $msg_body .= 'Email: ' . $data['Email'] . "<br />"; }
                if (!empty($data['Phone'])) { $msg_body .= 'Phone: ' . $data['Phone'] . "<br /><br />"; }
                if (!empty($data['Message'])) { $msg_body .= '----------- Message -----------' . "<br />" . $data['Message']; }

                $msg_to_client = 'Hi, ';
                if (!empty($data['Name'])) { $msg_to_client .= $data['Name'] . "<br /><br />"; } else { $msg_body .= '<br /><br />'; }
                $msg_to_client .= 'We have received your message at: ' . $date->format('Y-m-d H:i:s') . ', and we will get back to you as soon as possible.<br />';
                $msg_to_client .= '<br />Kind regards<br />Base Two team<br /><br />Your copy of the original message: <br />---------------------------------------------<br />';
                $msg_to_client .= $msg_body;

                $email_to_b2 = new Email($data['Email'], $recipient, 'Business inquery from webform', $msg_body);
                $email_to_b2->send();

                $email_to_sender = new Email('info@basetwo.co.nz', $data['Email'], 'Base Two has received your message', $msg_to_client);
                $email_to_sender->send();


                $form->sessionMessage('We have received your message, and will get back to you shortly.', 'good');
                return Controller::curr()->redirectBack();
            }

            $form->sessionMessage('Check the Recaptcha box to proof you are not a bot.', 'bad');
            return Controller::curr()->redirectBack();
        }

        $form->sessionMessage('Message didn\'t get sent, please try again!', 'bad');
        return Controller::curr()->redirectBack();
    }
}

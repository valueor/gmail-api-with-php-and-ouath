# gmail-api-with-php-and-ouath

구글 ouath를 이용하여 gmail의 메시지 발송 api를 이용하는 기능을 구현하던 중 
[PHPMAILER](https://github.com/PHPMailer/PHPMailer) 의
많은 library를 사용하기 다소 복잡함이 있어서 구현하게 되었습니다.

phpmailer를 이용하지 않고 oauth를 이용한 gmail api 메일 발송 기능

get_access_token_send_mail.php 파일은 구글의 access token을 받급받아서 gmail api를 
이용하여 메일을 발송하는 기능이 있습니다.

깃 사용이 미숙하여 불편을 드린점 양해 부탁드립니다.

### 사용법
1. 구글 oauth 추가
2. api 추가
3. client id 준비
4. client secret key 준비
5. api key 준비

### 문서 
1. [구글 Gmail api](https://developers.google.com/gmail/api/reference/rest/v1/users.messages/send)

### 주의사항
1. 웹 애플리케이션의 클라이언트 ID
    + 승인된 리디렉션 URI
    + 사용할 리디렉션 URI가 일치해야 함
    + 일치하지 않는경우 리디렉션 오류가 발생함


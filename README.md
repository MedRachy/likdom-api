[x] install jetstream
[x] remote as private repo to github
[x] run first migration
[x] migrate all tables

<!-- user authentication & autorization -->

[x] api/AuthController@login & api/AuthController@register

<!-- users -->

[x] user ressources
[x] get the logged in user data
[x] update user : name , email
[x] update user : adresse , ville
[] update user phone number : using nexmo sms verification
[x] update password
[0] reset password (same as web )
[] delete user account

<!-- Subsciptions -->

[] subscription ressources
[] create subscription
[] get user subscription  
[] get all valider / en_attente subscriptions
[] get all terminer subscriptions
[] confirme subscription
[] update subscription statut
[] delete subscription
[] attache / detache subscription with employees
[] add subscription to records

<!-- user testing -->

[x] test authentication login & register
[x] test get logged in user data
[x] test update user : name , email
[x] test update user email : must_be_unique
[x] test update user : adresse , ville
[x] test update password : can_be_updated
[x] test update password : must_match
[x] test update password : must_be_correct
[0] test reset password same as web

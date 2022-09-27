[x] install jetstream
[x] remote as private repo to github
[x] run first migration

<!-- users -->

[x] user ressources
[x] get the logged in user data
[] update user : name , email , adresse , ville
[x] update password
[] reset password
[] update user phone number : using nexmo sms verification
[] delete user account

<!-- user authentication & autorization -->

[x] api/AuthController@login & api/AuthController@register
[] google auth
[] facebook auth

<!-- testing -->

[x] test authentication login & register
[x] test get logged in user data
[x] test update password : can_be_updated
[] test update password : must_match
[] test update password : must_be_correct
[] test reset password

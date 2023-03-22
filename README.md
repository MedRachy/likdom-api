## END POINTS

[x] Authentication and Registration

-   login : api/login
-   validate register : api/validate-register
-   register : api/register
-   logout : api/logout

[x] user account

-   get logged in user data : api/user
-   update user info (name & email) : api/user/update
-   update user password : api/user/update-password
-   password check : api/user/password-check
-   validate phone : api/user/validate-phone
-   update phone number : api/user/update-phone
-   delete a user account : api/user/delete
-   reset password : api/reset-password

[x] Offers Pages

-   get part offers : api/offers/part
-   get pro offers : api/offers/pro

[x] Subscriptions

-   create subscription : api/create/subscription
-   create subscription with contract : api/create/subscription-with-contract
-   get pro total price : api/get_pro_total_price/{nbr_hours}/{nbr_employees}/{nbr_passages}
-   get part total price : api/get_part_total_price/{nbr_hours}/{nbr_employees}/{nbr_passages}

[x] Reservation : sub just once

-   create reservation : api/create/reservation
-   get total price : api/get_total_price/{nbr_hours}/{nbr_employees}

[x] Recap

-   get subscription : api/recap/{subscription_id}
-   confirm subscription : api/confirm/{subscription_id}

[x] My Subscriptions / Reservations / historique

-   get all user pending and valid subscriptions : api/get/subscriptions
-   get all user pending and valid reservations : api/get/reservations
-   get all user concluded sub & reserv : api/get/concluded

[x] Contract

-   create a contract : api/create/contract
-   generate a contract as pdf doc : done from the front-end

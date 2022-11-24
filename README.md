## END POINTS

[x] Authentication and Registration

-   login : api/login
-   register : api/register

[] user account

-   update user info (name & email) : api/user/update
-   update user password : api/user/update-password
-   update phone number :
-   delete a user account : api/user/delete

[x] Offers Pages

-   get part offers : api/offers/part
-   get pro offers : api/offers/pro

[x] Subscriptions

-   create subscription : api/create/subscription
-   get pro total price : api/get_pro_total_price/{nbr_hours}/{nbr_employees}/{nbr_passages}
-   get part total price : api/get_part_total_price/{nbr_hours}/{nbr_employees}/{nbr_passages}

[x] Reservation : sub just once

-   create subscription : api/create/reservation
-   get total price : api/get_total_price/{nbr_hours}/{nbr_employees}

[x] Recap

-   get subscription : api/recap/{subscription_id}
-   confirm subscription : api/confirm/{subscription_id}

[x] Mes abonnements

-   get all user pending and valid subscriptions : api/get/subscriptions
-   get all user concluded subscriptions : api/get/subscriptions/concluded

[] Contract

-   create a contract : api/create/contract
-   generate a contract :

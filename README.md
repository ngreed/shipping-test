Po uzduoties aprasymo palikau siek tiek pastabu, ka turedamas laiko keisciau/prideciau papildomai.
Taip pat, norejau prideti, jog su Symfony darbines patirties kol kas neturiu, todel labai realu, kad nefollowinau best practices (ypatingai su services.yaml).

Kodas specialiai supushint'as dviem komitais. Pirmas komitas yra tai, koki projekta gavau pries pradedamas darba. Na, o antro neskaidziau smulkiau, kad butu patogu ziureti diff'a.

### Requirements
- We expect this to be Unit tested. It is not a requirement to have 100% coverage, but basic functionality should be tested.
- APIs should be mocked, returning hard-coded results.
- Even though exercise contains 3 providers only, design your code to be extensible and as flexible as possible. Implementing new providers should be very straightforward. If you want you can do only 2 shipping providers.
- Do not implement any persistence layer or ORM, entity should be constructed with mock data.

### Problem
Please implement a console command which would register a shipment for given shipping provider key. Provider key could be passed as an argument from STDIN. The rest order data could be mocked.

Each shipping provider could deliver the Order (`\App\Entity\Order`), however in the future we might add validation to limit supported providers. Provider is chosen by `\App\Entity\Order::getShippingProviderKey` method which returns provider key: __ups__, __omniva__ or __dhl__.
Shipment is registered by calling `\App\Service\Order::registerShipping` method, which should ensure a chosen provider is notified about the new shipment.

Command should exit if shipment has been registered successfully.

### Provider specifications
- **UPS**, send by api to `upsfake.com/register` -> `order_id`, `country`, `street`, `city`, `post_code`
- **OMNIVA** - get pick up point id by calling the api `omnivafake.com/pickup/find` : `country`, `post_code`, then send registration to `omnivafake.com/register` using `pickup_point_id` and `order_id`
- **DHL**, send by api to `dhlfake.com/register` -> `order_id`, `country`, `address`, `town`, `zip_code` 

### Pastabos

- Suziureciau ka prideti i .gitignore kad nebutu nereikalingu failu.
- Priklausomai nuo situacijos prideti autorizacija, kad bet kas negaletu leisti komandos.
- Priklausomai nuo komandos kodinimo standartu pakeisti formatavima.
- Priklausomai nuo situacijos (jei manytume kad ateityje gali atsirasti daug provideriu su panasia/vienoda biznio logika) "panasius" providerius butu galima prideti automatizuotai (pvz useris pridetu per admin panel UI) ir laikyti duombazeje. Tie provideriai naudotu bendra is anksto aprasyta logika.
- Tiketina, kad produktas butu gerokai didesnis nei tai ka turim dabar. del to turbut reiketu deti konkretesnius klasiu/funkciju pavadinimus bei kurti gilesnius namespace'us.
- Nauju shipping provideriu pridejimui norejau padaryti, kad uztektu implementuoti ShippingProviderInterface ir uzsettinti konstanta su providerio key. Kiek ziurejau ta padaryti galima su _instanceof interfeiso tagais, taciau laiko taupymo sumetimais kol kas to neimplementavau.
- Testai kol kas coverina tik nedidele dali, taciau manau atspindi ivairias implementacijas.


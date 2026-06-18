=== MF Job Board (formerly MK Vacatures) ===

Standalone job board plugin. WordPress + Elementor. No external dependencies.
Version: 1.7.0

Languages in this file: English (primary) · Türkçe · Nederlands


##########################################################################
# ENGLISH
##########################################################################

>>> v1.7.0 — colors in settings + generic default email
- The dominant accent color (--mkv-accent) and the CTA button color (--mkv-cta)
  are now editable in wp-admin > Vacatures > Instellingen with a color picker.
  Accent drives the heading rule, bullets, arrow icons and links; CTA drives the
  apply / open-application buttons. Hover shades are derived automatically. Leave
  a field empty to keep the CSS default (#5E8DF7 / #00AD6D).
- The default application email is now generic (job@site.com) instead of a
  MijnKompaan address. Override it in Settings as before.

>>> v1.6.1 — CLEAN INSTALL
The plugin no longer creates ANY sample content on first activation. New
installs start empty (the Vacatures list is empty; the shortcode shows an
"no open positions" message). The MijnKompaan-specific Dutch sample content
has been removed. Existing MijnKompaan sites are unaffected; their listings
and pages stay in the database.

--------------------------------------------------------------------------
v1.6 — name + multilingual
--------------------------------------------------------------------------
- Plugin name is now "MF Job Board" (English, MF-branded). Folder and internal
  slugs are UNCHANGED (vacature CPT, [mk_vacatures] shortcode, settings, data
  stay intact). New branded shortcode: [mf_jobs] also works (identical to
  [mk_vacatures]).
- Multilingual: interface strings are now translatable. /languages ships Dutch
  (nl_NL) and Turkish (tr_TR); source language is English. WordPress shows the
  right language automatically based on the site language
  (mijnkompaan.nl = nl_NL -> Dutch).
- Content text (sample listings, landing page) is NOT included in translation;
  it is data.
- Can be updated in place: overwrite the files (folder name unchanged), then
  clear the cache. Data/settings/shortcode are preserved.

--------------------------------------------------------------------------
v1.5 — image + color
--------------------------------------------------------------------------
- FEATURED IMAGE per listing: edit a listing > "Featured image" on the right.
  Appears as a row thumbnail in the list and as a large image at the top of the
  detail view.
- Color separation: decorative elements (heading rule, bullets, arrow icons,
  back link) use MK Blue; GREEN is reserved for CTA buttons only
  (Apply / Open application).
- v1.4.1: rewrite rules refresh automatically on version change (prevents the
  single-listing URL from opening like an archive/blog).

--------------------------------------------------------------------------
v1.4 — fixes in this release
--------------------------------------------------------------------------
1) ARCHIVE ISSUE FIXED: the CPT archive (has_archive) and the category archive
   are disabled. Anyone landing on /vacature/ or a category URL is redirected
   to the list page automatically. So the theme's default blog archive
   (author/date/sidebar) is NO LONGER SHOWN.
2) SETTINGS PAGE: wp-admin > Vacatures > Instellingen
   - "Overzichtspagina": pick the vacatures (list) page. The detail-view
     "Terug naar alle vacatures" link and the archive redirect point here.
     (If "Automatisch detecteren" is selected, it finds the page that holds the
     shortcode by itself.)
   - "Sollicitatie e-mailadres": change the application email address here.
3) GREEN BUTTON TEXT IS WHITE: the theme turned all links blue; button text,
   the "Interesse?" heading and the mail link are now forced white with
   !important.
4) NO META ON DETAIL: the listing detail uses its own template, which does NOT
   print the theme's content-single part (author, date, comments); the header +
   page-banner + footer are preserved.

--------------------------------------------------------------------------
UPDATE STEPS (important)
--------------------------------------------------------------------------
1. Plugins > MK Vacatures > Delete, then upload the new zip and Activate.
   (Existing listings/pages are in the database, so they are not deleted.)
2. Settings > Permalinks > Save (permalink rules must be refreshed because
   rewrite/has_archive changed — activation also does this).
3. In wp-admin > Vacatures > Instellingen, select the vacatures page.
4. Clear SG Cache + clear the browser cache.

--------------------------------------------------------------------------
USAGE (summary)
--------------------------------------------------------------------------
LIST: put [mk_vacatures] on a normal theme page. page.php prints header +
page-banner + footer; the shortcode prints the "Open posities" list + the open
application. Free text/Elementor can be added above/below.
DETAIL: goes through the theme flow (no meta); listing fields are injected.

Shortcode parameters:
[mk_vacatures]                              -> heading + list + open application
[mk_vacatures aantal="5"]                   -> at most 5
[mk_vacatures categorie="finance"]          -> by category slug
[mk_vacatures titel="Open posities"]        -> heading text
[mk_vacatures info="Amersfoort & heel NL"]  -> note to the right of the heading
[mk_vacatures kop="nee"]                    -> hide the top heading
[mk_vacatures open_sollicitatie="nee"]      -> hide the bottom CTA block

Category (shown on the right in the list): edit each listing and assign it under
"Categorieën".
Colors: the variables at the top of assets/vacatures.css. Font: inherited from
the theme.


##########################################################################
# TÜRKÇE
##########################################################################

>>> v1.7.0 — ayarlarda renk + genel varsayılan mail
- Hakim vurgu rengi (--mkv-accent) ve CTA buton rengi (--mkv-cta) artık
  wp-admin > Vacatures > Instellingen'de renk seçici ile değiştirilebilir.
  Accent; başlık çizgisi, madde işaretleri, ok ikonları ve linkleri belirler.
  CTA; başvuru / açık başvuru butonlarını belirler. Hover tonları otomatik
  türetilir. Alanı boş bırakırsan CSS varsayılanı geçerli kalır
  (#5E8DF7 / #00AD6D).
- Varsayılan başvuru e-postası artık MijnKompaan adresi yerine genel bir adres
  (job@site.com). Eskisi gibi Ayarlar'dan değiştirilebilir.

>>> v1.6.1 — TEMİZ KURULUM
Eklenti artık ilk etkinleştirmede HİÇBİR örnek içerik oluşturmaz. Yeni
kurulumlar boş başlar (Vacatures listesi boş, shortcode "açık pozisyon yok"
mesajı gösterir). MijnKompaan'a özel Hollandaca örnek içerikler kaldırıldı.
Mevcut MijnKompaan sitesi etkilenmez; oradaki ilanlar/sayfa veritabanında kalır.

--------------------------------------------------------------------------
v1.6 — isim + çoklu dil
--------------------------------------------------------------------------
- Eklenti adı artık "MF Job Board" (İngilizce, MF markalı). Klasör/iç slug'lar
  AYNI kaldı (vacature CPT, [mk_vacatures] shortcode, ayarlar, veriler bozulmaz).
  Yeni markalı kısayol: [mf_jobs] de çalışır ([mk_vacatures] ile aynı).
- Çoklu dil: arayüz metinleri artık çevrilebilir. /languages içinde Hollandaca
  (nl_NL) ve Türkçe (tr_TR) hazır; kaynak diller İngilizce. WordPress'in site
  diline göre otomatik görünür (mijnkompaan.nl = nl_NL -> Hollandaca).
- İçerik metinleri (örnek ilanlar, landing sayfası) çeviriye dahil DEĞİL; veridir.
- Güncelleme yerinde yapılabilir: dosyaların üzerine yaz (klasör adı değişmedi),
  sonra önbelleği temizle. Veri/ayar/shortcode korunur.

--------------------------------------------------------------------------
v1.5 — görsel + renk
--------------------------------------------------------------------------
- Her ilana ÖNE ÇIKAN GÖRSEL: ilanı düzenle > sağdaki "Uitgelichte
  afbeelding". Listede satır görseli, detayda üstte büyük görsel olarak çıkar.
- Renk ayrımı: dekoratif öğeler (başlık çizgisi, madde işaretleri, ok
  ikonları, geri-dön linki) MK Blue; YEŞİL yalnızca CTA butonlarında
  (Solliciteer / Open sollicitatie).
- v1.4.1: sürüm değişince rewrite kuralları otomatik tazelenir (tekil ilan
  adresinin arşiv/blog gibi açılması sorununu önler).

--------------------------------------------------------------------------
v1.4 — bu sürümdeki düzeltmeler
--------------------------------------------------------------------------
1) ARŞİV SORUNU BİTTİ: CPT arşivi (has_archive) ve kategori arşivi kapatıldı.
   /vacature/ veya kategori adresine gelen olursa otomatik olarak liste
   sayfasına yönlendirilir. Yani tema varsayılan blog arşivi (author/tarih/
   sidebar) ARTIK GÖRÜNMEZ.
2) AYARLAR SAYFASI: wp-admin > Vacatures > Instellingen
   - "Overzichtspagina": vacatures (liste) sayfasını seç. Detaydaki
     "Terug naar alle vacatures" linki ve arşiv yönlendirmesi buraya gider.
     ("Automatisch detecteren" seçilirse shortcode'un olduğu sayfayı kendi bulur.)
   - "Sollicitatie e-mailadres": başvuru e-postasını buradan değiştirebilirsin.
3) YEŞİL BUTON YAZILARI BEYAZ: tema tüm linkleri mavi yapıyordu; buton
   yazıları, "Interesse?" başlığı ve mail linki artık !important ile beyaz.
4) DETAYDA META YOK: ilan detayı, temanın content-single parçasını (author,
   tarih, reacties) basMAYAN kendi şablonundan geçer; header + page-banner +
   footer korunur.

--------------------------------------------------------------------------
GÜNCELLEME ADIMLARI (önemli)
--------------------------------------------------------------------------
1. Eklentiler > MK Vacatures > Sil, sonra yeni zip'i yükle ve Etkinleştir.
   (Mevcut ilanlar/sayfalar veritabanında olduğu için silinmez.)
2. Ayarlar > Kalıcı Bağlantılar > Kaydet (rewrite/has_archive değiştiği için
   permalink kurallarını tazelemek gerekir — etkinleştirme bunu da yapar).
3. wp-admin > Vacatures > Instellingen'den vacatures sayfasını seç.
4. SG Cache legen + tarayıcı önbelleğini temizle.

--------------------------------------------------------------------------
KULLANIM (özet)
--------------------------------------------------------------------------
LİSTE: normal tema sayfasına [mk_vacatures] koy. page.php header + page-banner
+ footer'ı; shortcode "Open posities" listesi + açık başvuruyu basar. Üstüne/
altına serbestçe metin/Elementor eklenir.
DETAY: tema akışından geçer (meta yok), ilan alanları enjekte edilir.

Shortcode parametreleri:
[mk_vacatures]                              -> başlık + liste + açık başvuru
[mk_vacatures aantal="5"]                   -> en fazla 5
[mk_vacatures categorie="finance"]          -> kategori slug'ına göre
[mk_vacatures titel="Open posities"]        -> başlık metni
[mk_vacatures info="Amersfoort & heel NL"]  -> başlığın sağındaki not
[mk_vacatures kop="nee"]                    -> üst başlığı gizle
[mk_vacatures open_sollicitatie="nee"]      -> alttaki CTA bloğunu gizle

Kategori (listede sağda görünür): her ilanı düzenleyip "Categorieën"den ata.
Renkler: assets/vacatures.css en üstteki değişkenler. Font: temadan miras.


##########################################################################
# NEDERLANDS
##########################################################################

>>> v1.7.0 — kleuren in instellingen + generiek standaard-e-mailadres
- De dominante accentkleur (--mkv-accent) en de CTA-knopkleur (--mkv-cta) zijn
  nu instelbaar in wp-admin > Vacatures > Instellingen met een kleurkiezer.
  Accent bepaalt de titellijn, opsommingstekens, pijlpictogrammen en links;
  CTA bepaalt de solliciteer- / open-sollicitatieknoppen. Hover-tinten worden
  automatisch afgeleid. Laat een veld leeg om de CSS-standaard te behouden
  (#5E8DF7 / #00AD6D).
- Het standaard sollicitatie-e-mailadres is nu generiek (job@site.com) in plaats
  van een MijnKompaan-adres. Pas het zoals voorheen aan in Instellingen.

>>> v1.6.1 — SCHONE INSTALLATIE
De plugin maakt bij de eerste activering GEEN voorbeeldinhoud meer aan. Nieuwe
installaties starten leeg (de Vacatures-lijst is leeg; de shortcode toont een
"geen open posities"-bericht). De MijnKompaan-specifieke Nederlandse
voorbeeldinhoud is verwijderd. Bestaande MijnKompaan-sites worden niet
beïnvloed; hun vacatures/pagina's blijven in de database staan.

--------------------------------------------------------------------------
v1.6 — naam + meertalig
--------------------------------------------------------------------------
- De pluginnaam is nu "MF Job Board" (Engels, MF-merk). De map en interne slugs
  zijn ONGEWIJZIGD (vacature CPT, [mk_vacatures] shortcode, instellingen,
  gegevens blijven intact). Nieuwe merk-shortcode: [mf_jobs] werkt ook
  (identiek aan [mk_vacatures]).
- Meertalig: interfaceteksten zijn nu vertaalbaar. /languages bevat Nederlands
  (nl_NL) en Turks (tr_TR); de brontaal is Engels. WordPress toont automatisch
  de juiste taal op basis van de sitetaal (mijnkompaan.nl = nl_NL -> Nederlands).
- Inhoudstekst (voorbeeldvacatures, landingspagina) valt NIET onder de vertaling;
  dat zijn gegevens.
- Kan ter plekke worden bijgewerkt: overschrijf de bestanden (mapnaam
  ongewijzigd) en wis daarna de cache. Gegevens/instellingen/shortcode blijven
  behouden.

--------------------------------------------------------------------------
v1.5 — afbeelding + kleur
--------------------------------------------------------------------------
- UITGELICHTE AFBEELDING per vacature: bewerk een vacature > "Uitgelichte
  afbeelding" rechts. Verschijnt als rij-thumbnail in de lijst en als grote
  afbeelding bovenaan de detailweergave.
- Kleurscheiding: decoratieve elementen (titellijn, opsommingstekens,
  pijlpictogrammen, terug-link) gebruiken MK Blue; GROEN is alleen voor
  CTA-knoppen (Solliciteer / Open sollicitatie).
- v1.4.1: rewrite-regels worden automatisch vernieuwd bij een versiewijziging
  (voorkomt dat de enkele-vacature-URL als archief/blog opent).

--------------------------------------------------------------------------
v1.4 — oplossingen in deze release
--------------------------------------------------------------------------
1) ARCHIEFPROBLEEM OPGELOST: het CPT-archief (has_archive) en het
   categoriearchief zijn uitgeschakeld. Wie op /vacature/ of een categorie-URL
   terechtkomt, wordt automatisch naar de lijstpagina doorgestuurd. Het
   standaard blogarchief van het thema (auteur/datum/sidebar) wordt dus NIET
   MEER GETOOND.
2) INSTELLINGENPAGINA: wp-admin > Vacatures > Instellingen
   - "Overzichtspagina": kies de vacatures (lijst)-pagina. De
     "Terug naar alle vacatures"-link in de detailweergave en de
     archiefdoorverwijzing wijzen hierheen.
     (Als "Automatisch detecteren" is geselecteerd, vindt het zelf de pagina met
     de shortcode.)
   - "Sollicitatie e-mailadres": wijzig hier het e-mailadres voor sollicitaties.
3) GROENE KNOPTEKST IS WIT: het thema maakte alle links blauw; knoptekst, de
   "Interesse?"-titel en de maillink zijn nu met !important wit gemaakt.
4) GEEN META OP DETAIL: het vacaturedetail gebruikt een eigen template dat het
   content-single-deel van het thema (auteur, datum, reacties) NIET afdrukt; de
   header + page-banner + footer blijven behouden.

--------------------------------------------------------------------------
UPDATE-STAPPEN (belangrijk)
--------------------------------------------------------------------------
1. Plugins > MK Vacatures > Verwijderen, upload daarna de nieuwe zip en
   Activeer. (Bestaande vacatures/pagina's staan in de database en worden dus
   niet verwijderd.)
2. Instellingen > Permalinks > Opslaan (de permalink-regels moeten worden
   vernieuwd omdat rewrite/has_archive is gewijzigd — de activering doet dit
   ook).
3. Selecteer in wp-admin > Vacatures > Instellingen de vacatures-pagina.
4. SG Cache legen + wis de browsercache.

--------------------------------------------------------------------------
GEBRUIK (samenvatting)
--------------------------------------------------------------------------
LIJST: plaats [mk_vacatures] op een normale themapagina. page.php drukt header +
page-banner + footer af; de shortcode drukt de "Open posities"-lijst + de open
sollicitatie af. Vrije tekst/Elementor kan erboven/eronder worden toegevoegd.
DETAIL: gaat via de themaflow (geen meta); vacaturevelden worden geïnjecteerd.

Shortcode-parameters:
[mk_vacatures]                              -> titel + lijst + open sollicitatie
[mk_vacatures aantal="5"]                   -> maximaal 5
[mk_vacatures categorie="finance"]          -> op categorie-slug
[mk_vacatures titel="Open posities"]        -> titeltekst
[mk_vacatures info="Amersfoort & heel NL"]  -> notitie rechts van de titel
[mk_vacatures kop="nee"]                    -> bovenste titel verbergen
[mk_vacatures open_sollicitatie="nee"]      -> onderste CTA-blok verbergen

Categorie (rechts in de lijst getoond): bewerk elke vacature en wijs deze toe
onder "Categorieën".
Kleuren: de variabelen bovenaan assets/vacatures.css. Lettertype: geërfd van het
thema.

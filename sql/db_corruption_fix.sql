/* these queries convert corrupted foreign characters (showing as $%^&*#&^%@$, etc) 
back to foreign characters in the database 
Note: DON'T run these twice, if run on correctly displayed foreign characters it will corrupt them to question marks.
*/
/* blog table */
/* title column */
UPDATE blog SET title = 
CONVERT(BINARY CONVERT(title USING latin1) USING utf8)
WHERE title IS NOT NULL;

/* content column */
UPDATE blog SET content = 
CONVERT(BINARY CONVERT(content USING latin1) USING utf8)
WHERE content IS NOT NULL;

/*
Some queries used to check database character set values and similar
SHOW VARIABLES LIKE 'character\_set\_%';

show variables like '%colla%';
show variables like '%charse%';

SHOW CREATE PROCEDURE updateBlogEntry;
*/

/* inventory_item table */
/* title column */
UPDATE inventory_item SET title = 
CONVERT(BINARY CONVERT(title USING latin1) USING utf8)
WHERE title IS NOT NULL;

/* author column */
UPDATE inventory_item SET author = 
CONVERT(BINARY CONVERT(author USING latin1) USING utf8)
WHERE author IS NOT NULL;

/* publisher column */
UPDATE inventory_item SET publisher = 
CONVERT(BINARY CONVERT(publisher USING latin1) USING utf8)
WHERE publisher IS NOT NULL;

/* donatedBy column */
UPDATE inventory_item SET donatedBy = 
CONVERT(BINARY CONVERT(donatedBy USING latin1) USING utf8) 
WHERE donatedBy IS NOT NULL;

/* library table */
/* DistrictName column */
UPDATE library SET DistrictName = 
CONVERT(BINARY CONVERT(DistrictName USING latin1) USING utf8) 
WHERE DistrictName IS NOT NULL;

/* MandalName column */
UPDATE library SET MandalName = 
CONVERT(BINARY CONVERT(MandalName USING latin1) USING utf8) 
WHERE MandalName IS NOT NULL;

/* VillageName column */
UPDATE library SET VillageName = 
CONVERT(BINARY CONVERT(VillageName USING latin1) USING utf8) 
WHERE VillageName IS NOT NULL;

/* Description column */
UPDATE library SET Description = 
CONVERT(BINARY CONVERT(Description USING latin1) USING utf8) 
WHERE Description IS NOT NULL;

/* parameters table */
/* value column */
UPDATE parameters SET value = 
CONVERT(BINARY CONVERT(value USING latin1) USING utf8) 
WHERE value IS NOT NULL;

/* project table */
/* description column */
UPDATE project SET description = 
CONVERT(BINARY CONVERT(description USING latin1) USING utf8) 
WHERE description IS NOT NULL;

/* the project table descriptions got corrupted to question marks, so these restore them to the values from the backup */
/*
    197: '15 ఆగస్ట్ 2016 నాడు, ఉన్నత పాఠశాల, ప్రాథమిక పాఠశాలల్లోని విద్యార్ధులకు, ఉపాధ్యాయులకు విద్యా ప్రోత్సాహక బహుమతులు యివ్వటం ఈ ప్రాజెక్ట్ యొక్క ముఖ్య ఉద్దేశం.'
    198:'15 ఆగస్ట్ 2016 నాడు, ఉన్నత పాఠశాల, ప్రాథమిక పాఠశాలల్లోని విద్యార్ధులకు, ఉపాధ్యాయులకు విద్యా ప్రోత్సాహక బహుమతులు యివ్వటం ఈ ప్రాజెక్ట్ యొక్క ముఖ్య ఉద్దేశం.'
    200: 'మన గ్రామము జిల్లా పరిషత్ పాఠశాల నుండి, ఉత్తీర్ణులైన ప్రతిభావంతులైన విద్యార్ధులను, పేద విద్యార్ధులను, సేవా గుణం ఉన్న విద్యార్ధులను ప్రోత్సహించాలనే ఉద్దేశంతో, 2015 సంవత్సరములో, 2016 సంవత్సరములో, ఆగస్ట్ 15 నాడు, రూ.5000 చొప్పున కొన్ని స్కాలర్ షిప్స్ యిచ్చిన '
    201: 'తొమ్మిది, పదో తరగతి చదువుతున్న 190 మందికి, త్రిభాషా నిఘంటువుల ఉచిత పంపిణీ'
    202: 'రోటరీ క్లబ్ - వాష్ ఇన్ స్కూల్స్ అనే పథకము\r\nగళ్ళా సాంబశివరావు (చిలకలూరి పేట) గారి ద్వారా మన హై స్కూలు లో ( Rs.1,80,000 గ్రాంట్, 55,800 మ్యాచింగ్) అమలు పరిచాము. స్పాన్సర్స్ వివరాలు..'
    203: '15 ఆగస్ట్ 2020 నాడు, ఉన్నత పాఠశాల, ప్రాథమిక పాఠశాలల్లోని విద్యార్ధులకు, ఉపాధ్యాయులకు విద్యా ప్రోత్సాహక బహుమతులు యివ్వటం ఈ ప్రాజెక్ట్ యొక్క ముఖ్య ఉద్దేశం.'
*/

UPDATE project 
SET description = '15 ఆగస్ట్ 2016 నాడు, ఉన్నత పాఠశాల, ప్రాథమిక పాఠశాలల్లోని విద్యార్ధులకు, ఉపాధ్యాయులకు విద్యా ప్రోత్సాహక బహుమతులు యివ్వటం ఈ ప్రాజెక్ట్ యొక్క ముఖ్య ఉద్దేశం.'
WHERE project_id = 197;

UPDATE project 
SET description = '15 ఆగస్ట్ 2016 నాడు, ఉన్నత పాఠశాల, ప్రాథమిక పాఠశాలల్లోని విద్యార్ధులకు, ఉపాధ్యాయులకు విద్యా ప్రోత్సాహక బహుమతులు యివ్వటం ఈ ప్రాజెక్ట్ యొక్క ముఖ్య ఉద్దేశం.'
WHERE project_id = 198;

UPDATE project 
SET description = 'మన గ్రామము జిల్లా పరిషత్ పాఠశాల నుండి, ఉత్తీర్ణులైన ప్రతిభావంతులైన విద్యార్ధులను, పేద విద్యార్ధులను, సేవా గుణం ఉన్న విద్యార్ధులను ప్రోత్సహించాలనే ఉద్దేశంతో, 2015 సంవత్సరములో, 2016 సంవత్సరములో, ఆగస్ట్ 15 నాడు, రూ.5000 చొప్పున కొన్ని స్కాలర్ షిప్స్ యిచ్చిన '
WHERE project_id = 200;

UPDATE project 
SET description = 'తొమ్మిది, పదో తరగతి చదువుతున్న 190 మందికి, త్రిభాషా నిఘంటువుల ఉచిత పంపిణీ'
WHERE project_id = 201;

UPDATE project 
SET description = 'రోటరీ క్లబ్ - వాష్ ఇన్ స్కూల్స్ అనే పథకము\r\nగళ్ళా సాంబశివరావు (చిలకలూరి పేట) గారి ద్వారా మన హై స్కూలు లో ( Rs.1,80,000 గ్రాంట్, 55,800 మ్యాచింగ్) అమలు పరిచాము. స్పాన్సర్స్ వివరాలు..'
WHERE project_id = 202;

UPDATE project 
SET description = '15 ఆగస్ట్ 2020 నాడు, ఉన్నత పాఠశాల, ప్రాథమిక పాఠశాలల్లోని విద్యార్ధులకు, ఉపాధ్యాయులకు విద్యా ప్రోత్సాహక బహుమతులు యివ్వటం ఈ ప్రాజెక్ట్ యొక్క ముఖ్య ఉద్దేశం.'
WHERE project_id = 203;
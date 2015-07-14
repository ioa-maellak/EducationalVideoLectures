Educational Video Lectures
--------------------------------------------

Η εμφάνιση των Μαζικών Ανοικτών Διαδικτυακών Μαθημάτων (MOOC) καθώς και η αύξηση
των προσφερόμενων εκπαιδευτικών video στα social media υλοποιημένα από
πανεπιστήμια, εκπαιδευτικές εταιρίες ή οργανισμούς καθώς και από ιδιώτες
δημιούργησε νέες δυναμικές αξιοποίησης τους. Οι χρήστες βρίσκονται πλέον μπροστά
μια πληθώρα προσφερόμενων εκπαιδευτικών διαλέξεων όπου μπορούν να
παρακολουθήσουν ανάλογα τις ανάγκες τους.

Σε μια προσπάθεια ελαχιστοποιησης του χρόνου που ειναι αναγκασμενοι οι χρήστες
να σπαταλούν ώστε να βουν το καταλληλο βίντεο για αυτούς πραγματοποιούμε
διαδικασίες οι οποίες στοχευουν σε αυτο το σκοπό.

Με τη χρηση των **PHP** (Zend) και **YouTube API** μπορουν να υλοποιηθούν
διαδικασίες οι οποίες αναζητούν, φιλτράρουν και αξιοποιούν δεδομενά και
μεταδεδομένα των σελίδων που περιέχουν τα βίντεο καθως και του περιεχόμενου των
βίντεο (transcripts), δηλαδή των κειμένων των ομιλητών, με εφαρμογή στον
μεγαλύτερο παγκοσμίως πάροχο βίντεο που ειναι το YouTube.

![](<https://github.com/ioa-maellak/EducationalVideoLectures/blob/master/read.me.eduvidlec.jpg?raw=true>)

### Δημιουργήσαμε για το σκοπό αυτό και εμπλουτίζουμε συνεχώς τα παρακατω :

-   **search\_videos.php**

*αναζήτηση εκαιδευτικών βίντεο βάση λέξεων κλειδιών κι αποθηκευσή των videoId
τους σε αρχείο κειμένου.*

-   **retrive\_metadata\_from\_video.php**

*λήψη μεταδεδομένων από συγκεκριμένο βίντεο (videoId), likes, disklies, views,
author κλπ.*

-   **create\_unique\_videoid\_list.php**

*δημιουργία λίστας videoId με μοναδικές τιμές (σε περίπτωση που κάποια βίντεο
εμπίπτουν σε περισσότερες κατηγορίες να μην επαναλαμβάνονται).*

-   **create\_transcript.php**

*εξαγωγή κειμένου ομιλίας του κάθε βίντεο σε ξεχωριστό αρχείο.*

 

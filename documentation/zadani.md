# Aplikace pro správu poznámek

Tato semestrální práce se zabývá návrhem a implementací webové aplikace pro správu poznámek.  
Aplikace umožňuje uživatelům vytvářet, upravovat a organizovat osobní poznámky a zároveň poskytuje administrátorské nástroje pro správu uživatelů.

---

## Uživatelské role

Aplikace rozlišuje **tři různé role uživatelů**:

- Nepřihlášený uživatel
- Přihlášený uživatel
- Administrátor

---

## Nepřihlášený uživatel

Nepřihlášený uživatel má omezený přístup k aplikaci.  
Na úvodní (uvítací) stránce je k dispozici formulář pro:

- registraci nového uživatele,
- přihlášení existujícího uživatele.

Nepřihlášený uživatel nemá přístup k poznámkám ani k chráněným funkcím aplikace.

---

## Přihlášený uživatel

Po úspěšném přihlášení získá uživatel přístup ke své osobní části aplikace.  
Přihlášený uživatel může:

- zobrazit své poslední vytvořené poznámky (např. posledních 6),
- vytvářet nové poznámky,
- upravovat své vlastní poznámky,
- mazat své vlastní poznámky.

Každá poznámka může obsahovat:
- textový popis,
- datum vytvoření nebo úpravy,
- volitelné soubory, například obrázky.

---

## Administrátor

Administrátor má rozšířená oprávnění oproti běžnému uživateli.  
Kromě všech funkcí přihlášeného uživatele může administrátor:

- spravovat uživatelské účty,
- mazat přihlášené uživatele z aplikace.

Administrátor má přístup k administračnímu rozhraní určenému ke správě uživatelů systému.
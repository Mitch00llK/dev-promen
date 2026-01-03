# Contact Info Blocks Widget - Toegankelijkheid Documentatie

## WCAG 2.2 Level AA Compliance

Deze widget is ontworpen volgens de WCAG 2.2 Level AA richtlijnen voor toegankelijkheid.

## Semantische HTML Structuur

### Container
- `<section>` element met `role="region"`
- Unieke `id` voor elke widget instantie
- `aria-labelledby` verwijst naar een visueel verborgen `<h2>` heading
- `aria-describedby` geeft navigatie-instructies voor keyboard gebruikers

### Lijst Structuur
- `<ul>` met `role="list"` voor expliciete lijst semantiek
- `<li>` met `role="listitem"` voor elk contactblok
- `aria-label` op de lijst voor context

### Individuele Blokken
- `<article>` element voor elk contactblok (semantisch zelfstandig)
- Schema.org microdata:
  - `itemtype="https://schema.org/PostalAddress"` voor adresblok
  - `itemtype="https://schema.org/ContactPoint"` voor telefoon/email blokken
- `itemprop` attributen voor gestructureerde data

## ARIA Attributen

### Headings
- Dynamische heading tags (h1-h6, configureerbaar)
- Unieke `id` attributen voor `aria-labelledby` referenties
- Semantische hiërarchie wordt behouden

### Icons
- `aria-hidden="true"` op decoratieve iconen
- Icons worden niet voorgelezen door screen readers

### Links
- Beschrijvende `aria-label` attributen:
  - "Bel [telefoonnummer]" voor telefoon links
  - "Stuur een e-mail naar [email]" voor email links
- Dubbele content voor toegankelijkheid:
  - Zichtbare content in `<span aria-hidden="true">`
  - Screen reader content in `<span class="screen-reader-text">`
- `rel="nofollow"` voor betere SEO en privacy

### Live Regions
- ARIA live region voor dynamische aankondigingen
- `role="status"` en `aria-live="polite"` voor niet-intrusieve updates
- Aankondigingen bij:
  - Keyboard navigatie tussen blokken
  - Link activatie
  - Animatie voltooiing

## Keyboard Navigatie

### Ondersteunde Toetsen
- **Pijltjestoetsen (↑↓ of ←→)**: Navigeer tussen contactblokken
- **Home**: Spring naar eerste blok
- **End**: Spring naar laatste blok
- **Enter/Spatie**: Activeer gefocuste link
- **Tab**: Standaard tab navigatie
- **Escape**: Annuleer navigatie en verwijder focus states

### Navigatie Feedback
- Visuele focus indicator op actief blok
- Screen reader aankondiging: "[Titel], [Type], [X] van [Totaal]"
- Focus blijft behouden tijdens keyboard navigatie

## Focus Management

### Focus States
- `:focus-visible` pseudo-class voor keyboard-only focus
- Duidelijke focus indicator (3px outline met offset)
- Verhoogde z-index voor gefocuste blokken
- Box-shadow voor extra visuele nadruk

### Focus-within
- Container krijgt focus wanneer kind-elementen focus hebben
- Subtielere indicator voor parent container

## Contrast en Kleuren

### WCAG Compliance
- Minimum contrast ratio 4.5:1 voor normale tekst
- Minimum contrast ratio 3:1 voor grote tekst en UI componenten
- Dark mode ondersteuning met aangepaste kleuren
- High contrast mode ondersteuning

### Kleuren Gebruikt
- Primary: `#002855` (donkerblauw)
- Background: `#f4d19b` (beige)
- Focus: `#002855` met opacity varianten
- Contrast ratio wordt automatisch gevalideerd via utility functies

## Reduced Motion

### Ondersteuning
- Detectie van `prefers-reduced-motion: reduce` media query
- Automatische deactivatie van animaties
- Instant zichtbaarheid van content zonder transities
- JavaScript én CSS ondersteuning

### Implementatie
- Media query in CSS voor immediate fallback
- JavaScript detectie voor dynamische aanpassingen
- Screen reader aankondiging bij deactivatie
- Blijft luisteren naar systeemwijzigingen

## Screen Reader Optimalisaties

### Hidden Content
- `.screen-reader-text` class voor visueel verborgen content
- Correcte clip-path implementatie
- Focusbaar maken van verborgen content bij keyboard focus
- Gebruikte technieken:
  ```css
  clip: rect(0, 0, 0, 0);
  clip-path: inset(50%);
  ```

### Announcements
- Centrale live region voor alle aankondigingen
- Polite announcements (niet-intrusief)
- Automatische cleanup na 3 seconden
- Context-rijke berichten

### Content Duplicatie
- Zichtbare content voor visuele gebruikers
- Verbeterde content voor screen reader gebruikers
- Voorbeeld: "088 98 98 000 (klik om te bellen)"

## Animaties (GSAP)

### Toegankelijkheid
- Optioneel (standaard uit)
- Intersection Observer voor performance
- Respect voor `prefers-reduced-motion`
- `will-change` property alleen tijdens animatie
- Cleanup na voltooiing

### Types
- Fade in
- Slide up
- Slide in (van links)
- Scale in

### Performance
- `force3D: true` voor hardware acceleratie
- Stagger delays voor sequentiële animaties
- Passive event listeners
- Disconnect observer na gebruik

## Responsive Design

### Breakpoints
- Desktop: Horizontale layout
- Tablet (< 768px): 2 kolommen grid
- Mobile (< 480px): Verticale stack

### Touch Targets
- Minimaal 44x44px touch target (WCAG 2.2 Level AA)
- Voldoende ruimte tussen interactieve elementen
- Hover states werken ook op touch devices

## Print Accessibility

### Optimalisaties
- Border-only styling (geen background)
- `href` wordt getoond na links
- Page break avoidance voor blokken
- Zwart-wit vriendelijk
- Alle content blijft leesbaar

## Testing Checklist

### Handmatige Tests
- [ ] Screen reader navigatie (NVDA, JAWS, VoiceOver)
- [ ] Keyboard-only navigatie
- [ ] Focus visibility
- [ ] Zoom tot 200% zonder data loss
- [ ] Touch device interactie
- [ ] Print preview
- [ ] Color contrast met tool (bijv. WebAIM Color Contrast Checker)

### Automated Tests
- [ ] axe DevTools
- [ ] WAVE
- [ ] Lighthouse Accessibility Score
- [ ] HTML validator

### Browser Tests
- [ ] Chrome + ChromeVox
- [ ] Firefox + NVDA
- [ ] Safari + VoiceOver
- [ ] Edge + Narrator

## Utility Functions

De widget maakt gebruik van `Promen_Accessibility_Utils` class met:

### ID Generatie
```php
Promen_Accessibility_Utils::generate_id($prefix, $widget_id)
```

### Contact Block Attributen
```php
Promen_Accessibility_Utils::get_contact_block_attrs($block_type, $data, $index, $widget_id)
```

### Toegankelijke Links
```php
Promen_Accessibility_Utils::get_accessible_phone_link($phone_number, $clickable)
Promen_Accessibility_Utils::get_accessible_email_link($email_address, $clickable)
```

### ARIA Helpers
```php
Promen_Accessibility_Utils::get_aria_label_attrs($label, $labelledby, $describedby)
Promen_Accessibility_Utils::get_aria_live_attrs($politeness, $atomic)
```

### Contrast Checking
```php
Promen_Accessibility_Utils::get_contrast_ratio($foreground, $background)
Promen_Accessibility_Utils::check_wcag_contrast($foreground, $background, $level, $size)
```

## Best Practices Toegepast

1. **Progressieve Enhancement**: Basis functionaliteit werkt zonder JavaScript
2. **Defensive Coding**: Controles op bestaan van elementen
3. **Performance**: Passive event listeners, debouncing, cleanup
4. **Separation of Concerns**: CSS voor styling, JS voor gedrag, HTML voor structuur
5. **Semantic HTML**: Correcte elementen voor correcte doelen
6. **ARIA als Enhancement**: Alleen waar HTML tekort schiet
7. **User Control**: Respect voor gebruikersvoorkeuren (motion, contrast)
8. **Clear Communication**: Duidelijke labels en instructies

## Bekende Beperkingen

- Schema.org data wordt niet gevalideerd door externe services
- Sommige oude browsers ondersteunen geen `clip-path`
- GSAP animaties vereisen externe library (CDN)

## Toekomstige Verbeteringen

- [ ] Ondersteuning voor RTL talen
- [ ] Custom color contrast warnings in Elementor editor
- [ ] Geautomatiseerde WCAG tests in build process
- [ ] Support voor meerdere telefoonnummers per blok
- [ ] Integratie met Google Structured Data

## Resources

- [WCAG 2.2 Guidelines](https://www.w3.org/WAI/WCAG22/quickref/)
- [ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/)
- [Schema.org ContactPoint](https://schema.org/ContactPoint)
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)

---

**Versie**: 2.0.0  
**Laatst bijgewerkt**: November 2024  
**WCAG Level**: AA (2.2)


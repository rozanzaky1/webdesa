# Quick Guide: Responsive Design Classes

## Responsive Breakpoints

| Breakpoint | Size | Device |
|------------|------|--------|
| xs | < 576px | Phone |
| sm | ≥ 576px | Phone Landscape |
| md | ≥ 768px | Tablet |
| lg | ≥ 992px | Desktop |
| xl | ≥ 1200px | Large Desktop |

## Custom Utility Classes

### Display Control
```html
<!-- Hide on mobile, show on desktop -->
<div class="d-mobile-none">Desktop Only</div>

<!-- Hide on desktop, show on mobile -->
<div class="d-desktop-none">Mobile Only</div>
```

### Text Alignment Responsive
```html
<!-- Center text on tablet/mobile -->
<p class="text-md-center">Centered on tablet/mobile</p>

<!-- Center text on mobile only -->
<p class="text-sm-center">Centered on mobile</p>
```

### Spacing (Bootstrap Native)
```html
<!-- Padding -->
<div class="p-5 p-md-4 p-sm-3">Responsive padding</div>

<!-- Margin -->
<div class="m-5 m-md-4 m-sm-3">Responsive margin</div>

<!-- Margin Bottom -->
<div class="mb-5 mb-md-4 mb-sm-3">Responsive bottom margin</div>
```

### Grid System
```html
<!-- 4 columns on desktop, 2 on tablet, 1 on mobile -->
<div class="row">
    <div class="col-12 col-md-6 col-lg-3">Card 1</div>
    <div class="col-12 col-md-6 col-lg-3">Card 2</div>
    <div class="col-12 col-md-6 col-lg-3">Card 3</div>
    <div class="col-12 col-md-6 col-lg-3">Card 4</div>
</div>
```

### Buttons
```html
<!-- Full width on mobile -->
<button class="btn btn-primary btn-block d-sm-inline-block">Submit</button>

<!-- Different sizes -->
<button class="btn btn-lg btn-md-default btn-sm-sm">Adaptive Button</button>
```

### Typography
```html
<!-- Responsive headings (auto-scaled) -->
<h1>Main Title</h1>
<h2>Subtitle</h2>
<p>Body text</p>
```

## Common Patterns

### Card Grid
```html
<div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
        <div class="card">
            <!-- Card content -->
        </div>
    </div>
</div>
```

### Hero Section
```html
<section class="hero-section" style="height: 600px;">
    <!-- Desktop: 600px, Tablet: 500px, Mobile: 400px (auto-adjusted) -->
</section>
```

### Navigation
```html
<nav class="navbar navbar-expand-lg">
    <!-- Collapses to hamburger menu on mobile -->
</nav>
```

### Form
```html
<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label>Name</label>
        <input type="text" class="form-control">
    </div>
    <div class="col-12 col-md-6 mb-3">
        <label>Email</label>
        <input type="email" class="form-control">
    </div>
</div>
```

### Stats Cards
```html
<div class="row">
    <div class="col-6 col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number">1,234</div>
            <div class="stat-label">Users</div>
        </div>
    </div>
</div>
```

## Testing Commands

### Chrome DevTools
```
F12 - Open DevTools
Ctrl + Shift + M - Toggle Device Mode
Ctrl + Shift + C - Inspect Element
```

### Common Test Sizes
- iPhone SE: 375 x 667
- iPhone 12 Pro: 390 x 844
- iPad: 768 x 1024
- Galaxy S20: 360 x 800
- Desktop: 1920 x 1080

## Tips

1. **Mobile First**: Design for mobile, then enhance for desktop
2. **Touch Targets**: Minimum 44x44px for buttons on mobile
3. **Font Size**: Minimum 16px for body text (prevents zoom on iOS)
4. **Images**: Always use responsive images with max-width: 100%
5. **Tables**: Wrap in `.table-responsive` for horizontal scroll
6. **Modals**: Test on small screens, ensure readable
7. **Forms**: Stack vertically on mobile
8. **Navigation**: Use hamburger menu on mobile

## Quick Fixes

### Text Too Small
```css
@media (max-width: 576px) {
    p { font-size: 0.875rem; }
}
```

### Element Overflow
```css
.element {
    max-width: 100%;
    overflow-x: auto;
}
```

### Button Too Small
```css
@media (max-width: 576px) {
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
}
```

### Image Not Scaling
```css
img {
    max-width: 100%;
    height: auto;
}
```

---
**Quick Reference - Web Desa Responsive Design**

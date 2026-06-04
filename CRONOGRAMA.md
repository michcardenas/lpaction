# Cronograma Lp(a)ction — Entrega 20 de junio 2026

**Periodo:** lunes 1 jun → sábado 20 jun 2026 (20 días)
**Objetivo:** MVP web funcional y demostrable, desplegado en servidor de pruebas.

---

## 🎯 Alcance INCLUIDO en la entrega del 20/06

- Landing completa (7 secciones) + footer + responsive + desplegada
- Registro de profesional sanitario + login + roles
- Dashboard del curso: 3 módulos con estados, bloqueo progresivo y gamificación (avance, Scope EXP, vidas)
- **Módulo 1 funcional**: etapas con sidebar, contenido + bibliografía, quiz inline con feedback, sistema de error/penalización/retroceso, XP y progreso, visor de imágenes
- Datos demo cargados para Módulo 1
- Base de datos diseñada para TODO el alcance futuro

## ⛔ Fuera de alcance del 20/06 (fases siguientes)

- Módulos 2 y 3 completos · resto de etapas del Módulo 1
- CMS admin completo (carga de contenido por el comité)
- Evaluación final · diploma SEAFORMEC · encuesta de satisfacción
- Dashboard de métricas · pulido visual avanzado

---

## ✅ Lista de tareas por área

### A. Landing (cierre)
- [ ] Footer (Novartis/Qualimed/legal)
- [ ] Logo SEC en el header
- [ ] Textura `fondo_decisiones.png` (sección 5)
- [ ] QA responsive (móvil/tablet/desktop)
- [ ] Despliegue en Hostinger

### B. Base e infraestructura
- [ ] Scaffolding de autenticación (Breeze)
- [ ] Roles: alumno / admin / comité
- [ ] Esquema BD dominio (usuarios, cursos, módulos, etapas, inscripciones, progreso, xp_transactions, logros, quiz, diplomas, encuestas)
- [ ] Migraciones

### C. Registro / Login profesional sanitario
- [ ] Formulario registro (especialidad, hospital, tipo de centro, años, nº colegiado)
- [ ] Validaciones + gating profesional
- [ ] Login + recuperación de contraseña
- [ ] Pantallas "Registro exitoso" / "Ingresando a su curso"

### D. Dashboard del curso
- [ ] Layout home (nav Inicio/Tutoría/Autores/Perfil)
- [ ] Tarjetas de 3 módulos con estados (en curso/pendiente/apto/no apto/bloqueado)
- [ ] Bloqueo progresivo + fechas de disponibilidad
- [ ] Gamificación UI: barra de avance, Scope EXP, vidas (corazón)

### E. Módulo 1 (engine del caso)
- [ ] Sidebar de etapas con estados
- [ ] Render de etapa: tabs Contenido/Bibliografía + sub-tabs
- [ ] Quiz inline (multi-select + Comprobar + feedback)
- [ ] Sistema de error: penalización Scope, marca en error, retroceso/reintento
- [ ] Estado persistente por usuario × etapa
- [ ] XP transactions + progreso (%)
- [ ] Visor de imágenes médicas (zoom, figura, caption)

### F. QA, deploy y entrega
- [ ] Seeder de datos demo del Módulo 1
- [ ] Pruebas del flujo completo
- [ ] Despliegue final en Hostinger
- [ ] Entrega

---

## 📅 Cronograma día a día

### Semana 1 — Base y acceso (1–7 jun)
| Día | Tarea | Entregable |
|-----|-------|-----------|
| **Lun 1** | Cierre landing (footer, SEC, textura) + deploy inicial Hostinger | Landing en vivo |
| **Mar 2** | QA responsive landing + scaffolding auth + roles | Auth base |
| **Mié 3** | Esquema BD dominio + migraciones | BD lista |
| **Jue 4** | Registro profesional sanitario (form + validación) | Registro funcional |
| **Vie 5** | Login + recuperación + pantallas registro-exitoso/ingresando | **Hito: acceso completo** |
| Sáb 6 / Dom 7 | Buffer + pruebas de auth | — |

### Semana 2 — Dashboard y gamificación (8–14 jun)
| Día | Tarea | Entregable |
|-----|-------|-----------|
| **Lun 8** | Layout home del curso (nav + estructura) | Dashboard base |
| **Mar 9** | Tarjetas de módulos + estados + bloqueo progresivo | Estados |
| **Mié 10** | Gamificación UI (avance, Scope EXP, vidas) + modelo XP | Gamificación |
| **Jue 11** | Estructura Módulo 1: sidebar de etapas + navegación | Navegación módulo |
| **Vie 12** | Render de etapa: tabs Contenido/Bibliografía + sub-tabs | **Hito: dashboard navegable** |
| Sáb 13 / Dom 14 | Buffer + integración dashboard↔módulo | — |

### Semana 3 — Engine del caso y entrega (15–20 jun)
| Día | Tarea | Entregable |
|-----|-------|-----------|
| **Lun 15** | Quiz inline (multi-select + Comprobar + feedback) | Quiz |
| **Mar 16** | Sistema error: penalización, marca, retroceso, estado persistente | Lógica de error |
| **Mié 17** | XP transactions + progreso + visor de imágenes médicas | Progreso real |
| **Jue 18** | Seeder demo Módulo 1 (2-3 etapas) + integración flujo | Flujo integrado |
| **Vie 19** | QA flujo completo + deploy final Hostinger | **Hito: Módulo 1 end-to-end** |
| **Sáb 20** | Revisión final + ajustes | **🚀 ENTREGA** |

---

## ⚠️ Dependencias y riesgos

- **Contenido editorial** de las etapas (textos, preguntas, bibliografía): si no llega del comité, se usan **datos demo** para el MVP.
- **Acceso al deploy**: contraseña BD Hostinger, document root → `/public`, `vendor/` en servidor.
- **Acreditación SEAFORMEC**: no bloquea el MVP (diploma es fase posterior).
- **Riesgo principal**: el engine de etapas/quiz (Semana 3) es lo más complejo. Por eso las semanas 1-2 dejan base sólida y la 3 se enfoca solo en eso.

## 🚩 Hitos de revisión con el cliente
- **Vie 5** — Acceso (registro/login) + BD
- **Vie 12** — Dashboard navegable con gamificación
- **Vie 19** — Módulo 1 funcional end-to-end
- **Sáb 20** — Entrega del MVP desplegado

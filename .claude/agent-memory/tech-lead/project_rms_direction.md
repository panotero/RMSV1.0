---
name: project-rms-direction
description: Repo is becoming a Recruitment Management System (RMS), not a generic admin template — product direction context
metadata:
  type: project
---

This repo (RMSv1) started as a generic Laravel 10 admin template but is now being built into a **Recruitment Management System (RMS)** for caregiver/home-care hiring (client references "Comfort Keepers", "Caregiver Application" form).

**Why:** CLAUDE.md's top still frames the repo as a domain-less "foundation," but a full Recruitment module (dynamic application forms, applicant pipeline, post-interview checklists, team-scoped visibility) was designed and built. The feature design was pre-approved by the user through several rounds of review before implementation — build to spec rather than re-deriving architecture.

**How to apply:** Treat recruitment/hiring as the real product domain when weighing suggestions. Future feature work will likely extend the applicant pipeline (statuses New→In Review→Interview→Offer→Hired/Rejected), the form builder, or team-based access. When something conflicts with the "generic template" framing, the RMS direction wins. The module itself is documented in CLAUDE.md's "What is actually implemented" list — read that for current structure.

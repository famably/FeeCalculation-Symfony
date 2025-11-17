# Fee Calculation Engine (PHP 8.4)

## Overview
This repository contains a production-ready **loan fee calculation engine** built with PHP 8.4.  
It is designed around clean architecture principles, extensible domain logic, and a stable CLI interface suitable for integration into financial workflows or internal tooling.

The system calculates loan fees based on configurable breakpoint tables, linear interpolation rules, rounding constraints, and term‑based fee structures.  
It is built for reliability, clarity, and extensibility—allowing additional rules, breakpoint sources, or output formats to be added without modifying core logic.

---

## Features

- **Domain‑Driven Fee Calculation**
  - Linear interpolation between breakpoints  
  - Term‑specific fee tables  
  - Configurable fee providers  
  - No formula assumptions—fee sources are fully data-driven

- **Rounding Engine**
  - Ensures `loan_amount + fee` is divisible by £5  
  - Always rounds *up* to satisfy business constraints

- **Robust CLI Entrypoint**
  - Executed via `bin/calculate-fee <amount> <term>`  
  - Outputs normalized fee values (two decimals, no symbols)  
  - Proper exit codes and stderr handling for invalid states

- **Clean, Extensible Architecture**
  - SOLID‑compliant class structure  
  - Separation between domain, application, and infrastructure layers  
  - Easy to swap fee tables, storage, or rounding strategies

- **Fully Tested**
  - Comprehensive test coverage validating interpolation, boundary handling, edge cases, and rounding behavior

---

## Architecture

The project follows modern engineering practices:

### Domain Layer
Encapsulates the core business concepts:
- Fee Calculation Service  
- Breakpoint models  
- Term‑based fee tables  
- Rounding strategy  

### Application Layer
Coordinates input validation, request handling, and orchestration of domain services.

### Infrastructure Layer
Supplies:
- Breakpoint providers  
- Configuration storage  
- CLI runtime environment  

### Entry Point
The CLI command (`bin/calculate-fee`) acts as the single execution interface and only bootstraps the application. All logic resides in `src/` and `tests/`.

---

## Running the Fee Calculator

### 1. Install dependencies
```bash
composer install
```

### 2. Run the calculator
```bash
bin/calculate-fee 11500.00 24
```

Output example:
```
460.00
```

### 3. Running tests
```bash
composer test
```

---

## Fee Rules (Configurable)

- Loan amount: **£1,000 – £20,000**
- Term: **12 or 24 months**
- Values between breakpoints: **linearly interpolated**
- Fee + amount must be **divisible by £5** (round up)
- Breakpoints stored as configurable tables and may change at any time

This engine supports changing fee structures without modifying code.

---

## Extensibility

The system is built to grow:
- Add new terms (36, 48, etc.)
- Add new fee sources (JSON, DB, API)
- Add new rounding strategies
- Add multi‑currency rules
- Integrate into a larger financial platform

---

## Summary

This repository provides a clean, maintainable fee calculation engine built for real‑world financial operations.  
Its architecture, extensibility, and testability make it suitable as a foundation for loan pricing systems, internal finance tools, or more complex fee engines in production environments.

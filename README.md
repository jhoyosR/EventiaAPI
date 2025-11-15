<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Eventia Core API

## Introducción al proyecto

Eventia Core API es un backend profesional desarrollado en Laravel 10 para gestionar eventos, participantes y registros de asistencia. Funciona como núcleo para futuras aplicaciones web y móviles. El proyecto fue construido siguiendo principios de buena ingeniería, separación de responsabilidades, calidad del código, pruebas automatizadas y una pipeline CI completa.

## Arquitectura utilizada y explicación

El proyecto utiliza la arquitectura MVC estándar de Laravel, adaptada para un backend API.  
Se organiza de la siguiente forma:

- Los modelos representan las entidades principales del dominio.
- Los controladores son delgados, delegando la lógica a servicios dedicados.
- La capa de servicios contiene la lógica de negocio, lo que mejora la mantenibilidad y facilita las pruebas.
- Las solicitudes (Form Request) se encargan de validar los datos de entrada.
- Los recursos transforman la salida y garantizan respuestas JSON limpias y consistentes.
- Las pruebas están organizadas por niveles: unitarias, de integración y de sistema (E2E).

Esta estructura permite cumplir los principios SOLID, facilita la escalabilidad y asegura un código limpio y profesional.

## Requisitos

El proyecto funciona completamente con Laravel Sail, así que solo se necesita:

- Docker  
- Docker Compose  
- Git  

No es necesario instalar PHP, Composer o MySQL en el sistema operativo local.

## Instalación

Para instalar el proyecto, debe clonarse el repositorio, instalar las dependencias de Composer, crear el archivo de entorno basado en el archivo de ejemplo, levantar los servicios mediante Laravel Sail, generar la llave de la aplicación y finalmente ejecutar las migraciones para inicializar la base de datos.

## Ejecución en local

Para ejecutar el proyecto en local, se deben iniciar los servicios con Laravel Sail.  
El API queda disponible en el puerto configurado (generalmente 80).  
Para detener el entorno, simplemente se apagan los contenedores con Sail.

## Ejecución de pruebas

Las pruebas se encuentran organizadas de la siguiente manera:

- Pruebas unitarias: validan funcionalidades atómicas y la lógica de los servicios.
- Pruebas de integración: validan interacción entre módulos, base de datos y flujos funcionales.
- Pruebas de sistema (E2E): simulan el comportamiento de un usuario o un cliente API real.

Cada suite puede ejecutarse de forma individual o completa.

## Explicación del pipeline

El proyecto cuenta con un pipeline CI basado en GitHub Actions. Cada vez que se hace push o pull request a la rama main, se ejecutan los siguientes pasos:

1. **Clonación del repositorio**.  
2. **Instalación de dependencias con Composer**.  
3. **Generación automática del archivo .env para CI**, ajustando el host de la base de datos y Redis para usar los contenedores del pipeline.  
4. **Levantamiento del entorno completo con Laravel Sail**, incluyendo aplicación, MySQL y Redis.  
5. **Espera automática** mientras los servicios terminan de inicializar.  
6. **Generación de la llave de la aplicación y ejecución de migraciones**.  
7. **Análisis estático de código con PHPStan**, ejecutado dentro del contenedor de la aplicación.  
8. **Ejecución de pruebas unitarias**.  
9. **Ejecución de pruebas de integración**.  
10. **Ejecución de pruebas de sistema (E2E)**.  
11. **Apagado del entorno de Sail** al finalizar la ejecución.  
12. **Mensaje OK** si todos los pasos se ejecutan correctamente.  
13. **Marcado del pipeline como Failed** si alguna etapa presenta errores.

Este pipeline garantiza calidad continua, detección temprana de fallos y validación completa del sistema antes de incorporar cambios a la rama principal.

## Justificación de tecnologías elegidas

Se eligió Laravel debido a su madurez, documentación extensa, ecosistema sólido y herramientas integradas como Eloquent, migraciones, colas, validaciones, manejo de excepciones y generación de APIs de forma profesional.  
Laravel Sail facilita un entorno completamente aislado y uniforme mediante Docker, eliminando problemas de compatibilidad entre entornos.  
PHPStan se usa para garantizar calidad mediante análisis estático de código.  
GitHub Actions proporciona integración continua sin costo adicional, infraestructura segura y ejecución automatizada de todo el workflow del proyecto.  
La combinación de estas tecnologías garantiza un backend estable, escalable, testeable y listo para despliegue profesional.


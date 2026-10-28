# Directiva de Flujo de Trabajo - Entorno en Producción

## Estado del Proyecto
El proyecto se encuentra actualmente en **PRODUCCIÓN** en `https://sisprof.aulanova.org`.

## Reglas Obligatorias de Desarrollo y Control de Versiones

1. **Desarrollo Exclusivamente Local**:
   - Todos los cambios, ajustes, correcciones o nuevas funcionalidades deben desarrollarse y probarse **única y exclusivamente en el entorno local**.
   - **NUNCA** ejecutar `git push` ni subir cambios al repositorio remoto de forma automática o por iniciativa propia.

2. **Condición Estricta de Subida**:
   - La subida al repositorio remoto de GitHub (`origin`) queda estrictamente bloqueada hasta que el usuario dé su aprobación explícita enviando la orden:
     > **"Subelo a repositorio"**
   - Solo cuando el usuario envíe esa orden específica, se procederá a crear el commit y realizar el `git push`.

3. **Flujo de Trabajo Paso a Paso**:
   - **Paso 1:** El usuario solicita cambios o ajustes.
   - **Paso 2:** Se aplican y verifican los cambios únicamente en local.
   - **Paso 3:** Se informa al usuario de los cambios realizados para su revisión y prueba.
   - **Paso 4:** Se espera la confirmación explícita del usuario con la frase *"Subelo a repositorio"* para realizar el `git add`, `git commit` y `git push`.

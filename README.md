# SIGIP – Sistema de Gestión de Inventario y Pedidos para Spacio Muebles

**Integrantes:**

- [23410291 - Jorge Abdiel Hernández Ponce]
- [23410283 - Daniel Omar Soto Jiménez]
- [23410295 - Omar Gerardo López Alvarado]

---

## 1. Idea general

SIGIP (Sistema de Gestión de Inventario y Pedidos) es una aplicación web dirigida al dueño del negocio y al personal de ventas y almacén. SIGIP facilita el acceso al catálogo de productos, al registro de proveedores, a los movimientos de entrada y salida y al registro de pedidos, además cuenta un dashboard que muestra datos y estadísticas relevantes para el administrador del negocio. El propósito de SIGIP es ayudar a que negocios pequeños empiecen a digitalizarse, dejando atrás los registros manuales en hojas o cuadernos, o incluso aquellos que lo hacen digitalmente, pero sin conexión entre todas estas áreas. De esta manera, los negocios se verán beneficiados a la hora de reducir errores humanos y evitar pérdidas de información, logrando una gestión y funcionamiento del negocio más eficiente.

## 2. Descripción de entidades o módulos

| Entidad / Módulo | Descripción |
| --- | --- |
| **Usuarios** | Administra las cuentas del sistema y el rol (Administrador o Empleado). |
| **Categorías** | Clasifica los productos del catálogo (Salas, Recámaras, Comedores, etc). |
| **Productos** | Catálogo de artículos con código, nombre, descripción, categoría, precio, stock actual y stock mínimo. |
| **Proveedores** | Registro de los proveedores y de sus productos. |
| **Movimientos** | Registra entradas y salidas de los productos. |
| **Entregas** | Información de las entregas a realizar o ya realizadas |

Los módulos se relacionan así: un **Producto** pertenece a una **Categoría** y puede ser suministrado por uno o más **Proveedores**; cada **Movimiento de Inventario** y cada **Entrega** hace referencia a **Productos** y quedan asociados al **Usuario** que los generó.

## 3. Tipos de usuario (roles)

- **Administrador:** gestiona usuarios y roles, el catálogo de productos, los proveedores, revisa el historial completo de movimientos, ve el dashboard y genera los reportes del sistema.
- **Empleado:** consulta el catálogo, registra entradas y salidas, registra entregas y su estado. No tiene acceso a la gestión de usuarios ni a los reportes.

## 4. Servicios web

1. **Consulta pública de catálogo (JSON):** muestra el listado de productos disponibles (nombre, descripción, categoría, precio, existencia) en formato JSON, para ser usado en una aplicación web dirigida al cliente.
2. **Consulta de estado de pedido (JSON):** muestra la información de una entrega en específico, para ser usado como reporte o para darle información al empleado que realizara la entrega.

## 5. Procesos automáticos

1. **Alertas automáticas de stock bajo:** cuando la existencia de un producto llega a su stock mínimo o se agota, el sistema genera automáticamente una notificación (correo electrónico) para el Administrador.
2. **Generación periódica de reportes:** el sistema ejecuta de forma programada (semanal o al gusto) la generación de un reporte con el historial de movimientos y entregas, dejándolo disponible para el Administrador.

## 6. Requerimientos funcionales

| ID | Módulo | Nombre | Rol | Descripción del requerimiento | Prioridad |
| --- | --- | --- | --- | --- | --- |
| **RF-01** | Usuarios | Autenticar usuario | Sistema | El sistema solo dará acceso mediante correo y contraseña, limita lo que cada usuario puede ver según su rol. | Imprescindible |
| **RF-02** | Usuarios | Registrar usuario | Administrador | El sistema permitirá registrar nuevos usuarios asignándoles el rol de Administrador o Empleado. | Imprescindible |
| **RF-03** | Usuarios | Eliminar usuario | Administrador | El sistema permitirá eliminar usuarios. | Imprescindible |
| **RF-04** | Usuarios | Modificar usuario | Administrador | El sistema permitirá modificar los datos de un usuario y su rol. | Imprescindible |
| **RF-05** | Usuarios | Archivar usuario | Administrador | El sistema permitirá archivar a un usuario, deshabilitando el acceso del usuario al sistema y ocultándolo de registros y listas. | Imprescindible |
| **RF-06** | Usuarios | Consultar usuario | Administrador | El sistema permitirá consultar un usuario según su nombre, rol y otros datos | Imprescindible |
| **RF-07** | Productos | Registrar producto | Administrador | El sistema permitirá registrar un producto con código, nombre, descripción, categoría, precio, stock, stock mínimo e imagen. | Imprescindible |
| **RF-08** | Productos | Eliminar producto | Administrador | El sistema permitirá eliminar productos y toda su información. | Imprescindible |
| **RF-09** | Productos | Modificar producto | Administrador | El sistema permitirá modificar los datos de un producto. | Imprescindible |
| **RF-10** | Productos | Archivar producto | Administrador | El sistema permitirá archivar un producto, ocultándolo de listas, registros y de ser usable por los Empleados. | Imprescindible |
| **RF-11** | Productos | Consultar producto | Administrador, Empleado | El sistema permitirá consultar y filtrar productos según sus datos | Imprescindible |
| **RF-12** | Productos | Consultar catálogo | Administrador, Empleado | El sistema permitirá buscar o filtrar productos por nombre o categoría | Imprescindible |
| **RF-13** | Productos | Actualizar catálogo | Administrador, Empleado | El sistema permitirá actualizar el catálogo para reflejar cambios recientes | Imprescindible |
| **RF-14** | Productos | Modificar catálogo | Administrador | El sistema permitirá modificar el catálogo y los productos visibles en él. | Imprescindible
| **RF-15** | Proveedores | Registrar proveedor | Administrador | El sistema permitirá registrar los datos de contacto de un proveedor y sus productos. | Imprescindible |
| **RF-16** | Proveedores | Eliminar proveedor | Administrador | El sistema permitirá eliminar proveedores y toda su información. | Imprescindible |
| **RF-17** | Proveedores | Modificar proveedor | Administrador | El sistema permitirá modificar los datos de un proveedor. | Imprescindible |
| **RF-18** | Proveedores | Archivar proveedor | Administrador | El sistema permitirá archivar un proveedor, ocultándolo de listas, registros y de ser usable por los Empleados. | Imprescindible |
| **RF-19** | Proveedores | Consultar proveedor | Administrador | El sistema permitirá consultar y filtrar proveedores según sus datos o productos | Imprescindible |
| **RF-20** | Movimientos | Registrar entrada de mercancía | Administrador, Empleado | El sistema permitirá registrar una entrada de mercancía y actualiza el inventario actual automáticamente. | Imprescindible |
| **RF-21** | Movimientos | Registrar salida de mercancía | Administrador, Empleado | El sistema permitirá marcar una salida de mercancía y actualizar el inventario actual automáticamente | Imprescindible |
| **RF-22** | Movimientos | Cancelar entrada de mercancía | Administrador, Empleado | El sistema permitirá cancelar una entrada de mercancía y actualizar el inventario actual automáticamente | Imprescindible |
| **RF-23** | Movimientos | Cancelar salida de mercancía | Administrador, Empleado | El sistema permitirá cancelar una salida de mercancía y actualizar el inventario actual automáticamente | Imprescindible |
| **RF-24** | Movimientos | Modificar entrada de mercancía | Administrador, Empleado | El sistema permitirá modificar una entrada de mercancía y actualizar el inventario actual automáticamente | Imprescindible |
| **RF-25** | Movimientos | Modificar salida de mercancía | Administrador, Empleado | El sistema permitirá modificar una salida de mercancía y actualizar el inventario actual automáticamente | Imprescindible |
| **RF-26** | Movimientos | Consultar entrada de mercancía | Administrador, Empleado | El sistema permitirá consultar las entradas de mercancía y filtrarlas según sus datos | Imprescindible |
| **RF-27** | Movimientos | Consultar salida de mercancía | Administrador, Empleado | El sistema permitirá consultar las salidas de mercancía y filtrarlas según sus datos | Imprescindible |
| **RF-28** | Entregas | Crear entrega | Administrador, Empleado | El sistema permitirá crear una entrega, seleccionando productos, cantidades, destino, cliente y estado. | Imprescindible |
| **RF-29** | Entregas | Modificar entrega | Administrador, Empleado | El sistema permitirá actualizar la información y el estado de una entrega | Imprescindible |
| **RF-30** | Entregas | Eliminar entrega | Administrador | El sistema permitirá eliminar una entrega ya registrada | Imprescindible |
| **RF-31** | Entregas | Consultar entrega | Administrador, Empleado | El sistema permitirá consultar una entrega ya registrada según sus datos | Imprescindible |
| **RF-32** | Entregas | Validar disponibilidad de stock | Sistema | El sistema impedirá crear una entrega si no hay suficiente inventario del producto a entregar | Imprescindible |
| **RF-33** | Dashboard | Visualizar dashboard | Administrador | El sistema mostrará información y estadísticas elegidas por el Administrador entre varias opciones disponibles. | Imprescindible |
| **RF-34** | Categorías | Crear categoría | Administrador | El sistema permitirá crear una categoría para ser asignada a los productos | Imprescindible |
| **RF-35** | Categorías | Modificar categoría | Administrador | El sistema permitirá modificar una categoría y actualizar automáticamente el sistema con los cambios. | Imprescindible |
| **RF-36** | Categorías | Archivar categoría | Administrador | El sistema permitirá archivar una categoria, deshabilitándola de ser usada por el Empleado y ocultándola a la vista | Imprescindible |
| **RF-37** | Categorías | Eliminar categoría | Administrador | El sistema permitirá eliminar una categoría y actualizar automáticamente el sistema con los cambios | Imprescindible |
| **RF-38** | Categorías | Consultar categoría | Administrador, Empleado | El sistema permitirá consultar una categoría y mostrar sus datos | Imprescindible |
| **RF-39** | Reportes | Generar catalogo | Sistema, Administrador | El sistema permitirá generar un catálogo en un formato apto para ser usado de manera externa | Imprescindible |
| **RF-40** | Reportes | Generar reporte de entrega | Sistema, Administrador, Empleado | El sistema permitirá generar un reporte de una o varias entregas en específico en un formato apto para ser usado de manera externa | Imprescindible |
| **RF-41** | Alertas | Alertar stock mínimo | Sistema | El sistema mandará un correo al administrador cuando un producto se encuentre en su stock mínimo. | Imprescindible |
| **RF-42** | Reportes | Generar reporte periódico | Sistema | El sistema genera y manda un correo al administrador con un reporte de movimientos y entregas según el lapso de tiempo establecido | Imprescindible |

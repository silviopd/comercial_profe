create or replace function f_listar_venta
(
  p_fecha1 date,
  p_fecha2 date,
  p_tipo int
)

returns table
(
  nv integer,
  tip_com character,
  serie integer,
  doc integer,
  fec_vta date,
  cliente text,
  sub_total numeric,
  igv numeric,
  total numeric,
  por_igv numeric,
  estado text,
  usuario text
)
as
$body$
	begin
	  --consulta sql Select
	  return query
	  SELECT 
		  venta.numero_venta, 
		  venta.codigo_tipo_comprobante, 
		  venta.numero_serie, 
		  venta.numero_documento, 
		  venta.fecha_venta, 
		  cliente.apellido_paterno || ' '  ||  cliente.apellido_materno || ' ' || cliente.nombres  as cliente, 
		  venta.sub_total, 
		  venta.igv, 
		  venta.total, 
		  venta.porcentaje_igv, 
		  (case when venta.estado = 'E' then 'Emitido' else 'Anulado' end) as estado, 
		  personal.apellido_paterno || ' '  ||  personal.apellido_materno || ' ' || personal.nombres  as usuario
		FROM 
		  public.venta, 
		  public.cliente, 
		  public.usuario, 
		  public.personal
		WHERE 
		  cliente.codigo_cliente = venta.codigo_cliente AND
		  usuario.codigo_usuario = venta.codigo_usuario AND
		  usuario.dni_usuario = personal.dni

		  and 
                  (
		     case p_tipo
                       when 1 then venta.fecha_venta = current_date --solo hoy
                       when 2 then venta.fecha_venta >= p_fecha1 and venta.fecha_venta <= p_fecha2 --por rango de fechas
		       else
			     true --las ventas de todas las fechas
		     end
		  )
		;

	end;
$body$
language plpgsql;


select * from f_listar_venta('01-01-2016','31-05-2016',1);

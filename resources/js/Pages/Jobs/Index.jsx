import React from 'react';
import { Link, usePage, Head } from '@inertiajs/react';

export default function Index() {
  const { jobs, title, auth } = usePage().props;

  return (
    <div className="container mx-auto p-6">
      <Head title={title || 'Vacantes'} />
      <h1 className="text-2xl font-bold mb-4">Vacantes</h1>

      {/* Botón para crear nueva vacante (visible solo si hay usuario autenticado) */}
      {auth?.user && (
        <div className="mb-4">
          <Link
            href="/company/jobs/create"
            className="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Nueva vacante
          </Link>
        </div>
      )}

      <div className="space-y-4">
        {jobs.data.map(job => (
          <div key={job.id} className="border rounded p-4">
            <h2 className="text-xl font-semibold">{job.title}</h2>
            <p className="text-sm text-gray-600">{job.company?.name} • {job.location || 'Ubicación no especificada'}</p>
            <div className="mt-2">
              <Link className="text-blue-600 hover:underline" href={`/jobs/${job.id}`}>Ver detalle</Link>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}